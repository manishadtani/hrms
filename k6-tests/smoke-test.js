// ============================================================
// 🔥 EMS Smoke Test — Quick 10-user test to verify setup
// ============================================================
// Run this FIRST before the 2000-user test to make sure
// everything works correctly.
//
// Run: k6 run k6-tests/smoke-test.js
// ============================================================

import http from 'k6/http';
import { check, sleep, group } from 'k6';
import { Rate, Trend } from 'k6/metrics';
import { BASE_URL, USERS, extractCsrfToken } from './config.js';

const loginSuccess = new Rate('login_success');
const pageLoadTime = new Trend('page_load_time', true);

export const options = {
    vus: 5,           // Just 5 virtual users
    duration: '30s',   // Run for 30 seconds
    thresholds: {
        http_req_duration: ['p(95)<3000'],
        http_req_failed: ['rate<0.05'],
        login_success: ['rate>0.95'],
    },
};

export default function () {
    const user = USERS.employee;

    // ── Login ──
    group('Login', function () {
        const loginPage = http.get(`${BASE_URL}/login`);
        const ok = check(loginPage, {
            'login page status 200': (r) => r.status === 200,
            'has CSRF token': (r) => extractCsrfToken(r.body) !== null,
        });

        if (!ok) {
            console.error(`❌ Login page failed: status=${loginPage.status}`);
            loginSuccess.add(false);
            return;
        }

        const csrfToken = extractCsrfToken(loginPage.body);
        const loginRes = http.post(`${BASE_URL}/login`, {
            email: user.email,
            password: user.password,
            _token: csrfToken,
        }, { redirects: 5 });

        const loggedIn = check(loginRes, {
            'login status 200': (r) => r.status === 200,
            'landed on dashboard': (r) => r.url.includes('dashboard') || r.url.includes('home'),
        });

        loginSuccess.add(loggedIn);
        if (loggedIn) {
            console.log(`✅ VU ${__VU}: Logged in as ${user.email}`);
        } else {
            console.error(`❌ VU ${__VU}: Login failed — status=${loginRes.status}, url=${loginRes.url}`);
        }
    });

    sleep(1);

    // ── Dashboard ──
    group('Dashboard', function () {
        const start = Date.now();
        const res = http.get(`${BASE_URL}/employee/dashboard`);
        pageLoadTime.add(Date.now() - start);

        check(res, {
            'dashboard 200': (r) => r.status === 200,
        });
    });

    sleep(1);

    // ── Attendance ──
    group('Attendance', function () {
        const start = Date.now();
        const res = http.get(`${BASE_URL}/employee/attendance`);
        pageLoadTime.add(Date.now() - start);

        check(res, {
            'attendance 200': (r) => r.status === 200,
        });
    });

    sleep(1);

    // ── Logout ──
    group('Logout', function () {
        // Get CSRF token from any page (attendance page we just loaded has it)
        const page = http.get(`${BASE_URL}/employee/dashboard`);
        const csrfToken = extractCsrfToken(page.body);
        const res = http.post(`${BASE_URL}/logout`, {
            _token: csrfToken || '',
        }, { redirects: 5 });
        check(res, {
            'logout ok': (r) => r.status === 200,
        });
    });

    sleep(1);
}
