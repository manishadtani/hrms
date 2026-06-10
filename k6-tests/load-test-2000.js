// ============================================================
// 🚀 EMS Load Test — 2000 Users Scalability Test
// ============================================================
// This script simulates real-world traffic with 2000 concurrent
// users performing various actions on the EMS platform.
//
// Run: k6 run k6-tests/load-test-2000.js
// ============================================================

import http from 'k6/http';
import { check, sleep, group } from 'k6';
import { Rate, Trend, Counter } from 'k6/metrics';
import { BASE_URL, USERS, TEST_EMPLOYEES, getRandomUser, extractCsrfToken } from './config.js';

// ── Custom Metrics ──
const loginSuccess = new Rate('login_success');
const pageLoadTime = new Trend('page_load_time', true);
const failedPages = new Counter('failed_pages');

// ── Test Configuration ──
// Ramping up to 2000 users over time, holding, then ramping down
export const options = {
    stages: [
        // Warm-up phase
        { duration: '30s', target: 50 },     // Ramp to 50 users in 30s
        { duration: '30s', target: 200 },    // Ramp to 200 users
        { duration: '1m', target: 500 },     // Ramp to 500 users
        { duration: '1m', target: 1000 },    // Ramp to 1000 users
        { duration: '2m', target: 2000 },    // 🔥 Ramp to 2000 users
        { duration: '3m', target: 2000 },    // Hold at 2000 for 3 minutes (stress)
        { duration: '1m', target: 500 },     // Cool down to 500
        { duration: '30s', target: 0 },      // Ramp down to 0
    ],

    thresholds: {
        http_req_duration: ['p(95)<5000', 'p(99)<10000'],  // 95% under 5s, 99% under 10s
        http_req_failed: ['rate<0.10'],                     // Less than 10% errors
        login_success: ['rate>0.90'],                       // 90%+ login success
        page_load_time: ['p(95)<5000'],                     // Pages load in 5s
    },

    // Don't follow redirects automatically — we handle them
    // insecureSkipTLSVerify: true,  // Uncomment if using HTTPS with self-signed certs
};

// ── Main Test Function ──
// Each virtual user (VU) executes this function in a loop
export default function () {
    // Pick a random user from the pool of 50+ users
    const user = getRandomUser();

    // ── 1. Login Flow ──
    group('01_Login', function () {
        // GET login page
        const loginPage = http.get(`${BASE_URL}/login`);
        check(loginPage, {
            'login page loads': (r) => r.status === 200,
        });

        const csrfToken = extractCsrfToken(loginPage.body);
        if (!csrfToken) {
            loginSuccess.add(false);
            failedPages.add(1);
            return;
        }

        // POST login
        const loginRes = http.post(`${BASE_URL}/login`, {
            email: user.email,
            password: user.password,
            _token: csrfToken,
        }, { redirects: 5 });

        const loggedIn = check(loginRes, {
            'login successful': (r) => r.status === 200,
            'redirected to dashboard': (r) => r.url.includes('dashboard') || r.url.includes('home'),
        });

        loginSuccess.add(loggedIn);
        if (!loggedIn) {
            failedPages.add(1);
            return;
        }
    });

    sleep(Math.random() * 2 + 1); // 1-3s think time

    // ── 2. Dashboard ──
    group('02_Dashboard', function () {
        const start = Date.now();
        const res = http.get(`${BASE_URL}/employee/dashboard`);
        pageLoadTime.add(Date.now() - start);

        const ok = check(res, {
            'dashboard loads': (r) => r.status === 200,
        });
        if (!ok) failedPages.add(1);
    });

    sleep(Math.random() * 2 + 1);

    // ── 3. Attendance Page ──
    group('03_Attendance', function () {
        const start = Date.now();
        const res = http.get(`${BASE_URL}/employee/attendance`);
        pageLoadTime.add(Date.now() - start);

        check(res, {
            'attendance page loads': (r) => r.status === 200,
        });
    });

    sleep(Math.random() * 1.5 + 0.5);

    // ── 4. Leave Page ──
    group('04_Leaves', function () {
        const start = Date.now();
        const res = http.get(`${BASE_URL}/employee/leaves`);
        pageLoadTime.add(Date.now() - start);

        check(res, {
            'leaves page loads': (r) => r.status === 200,
        });
    });

    sleep(Math.random() * 1.5 + 0.5);

    // ── 5. Profile Page ──
    group('05_Profile', function () {
        const start = Date.now();
        const res = http.get(`${BASE_URL}/employee/profile`);
        pageLoadTime.add(Date.now() - start);

        check(res, {
            'profile page loads': (r) => r.status === 200,
        });
    });

    sleep(Math.random() * 2 + 1);

    // ── 6. Announcements ──
    group('06_Announcements', function () {
        const start = Date.now();
        const res = http.get(`${BASE_URL}/employee/announcements`);
        pageLoadTime.add(Date.now() - start);

        check(res, {
            'announcements page loads': (r) => r.status === 200,
        });
    });

    sleep(Math.random() * 1 + 0.5);

    // ── 7. Logout ──
    group('07_Logout', function () {
        const page = http.get(`${BASE_URL}/employee/dashboard`);
        const csrfToken = extractCsrfToken(page.body);
        const res = http.post(`${BASE_URL}/logout`, {
            _token: csrfToken || '',
        }, { redirects: 5 });
        check(res, {
            'logout successful': (r) => r.status === 200,
        });
    });

    sleep(Math.random() * 1 + 0.5);
}

// ── Summary Report ──
export function handleSummary(data) {
    const now = new Date().toISOString().replace(/[:.]/g, '-');
    return {
        'stdout': textSummary(data, { indent: ' ', enableColors: true }),
        [`k6-tests/results/summary-${now}.json`]: JSON.stringify(data, null, 2),
    };
}

import { textSummary } from 'https://jslib.k6.io/k6-summary/0.1.0/index.js';
