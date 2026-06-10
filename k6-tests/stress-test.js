// ============================================================
// 💥 EMS Stress Test — Find the Breaking Point
// ============================================================
// This test gradually increases load until the server breaks.
// Helps you find the MAXIMUM users your server can handle.
//
// Run: k6 run k6-tests/stress-test.js
// ============================================================

import http from 'k6/http';
import { check, sleep, group } from 'k6';
import { Rate, Trend, Counter } from 'k6/metrics';
import { BASE_URL, USERS, extractCsrfToken } from './config.js';

const loginSuccess = new Rate('login_success');
const pageLoadTime = new Trend('page_load_time', true);
const errorCount = new Counter('errors');

export const options = {
    stages: [
        // Phase 1: Normal load
        { duration: '1m', target: 100 },

        // Phase 2: High load
        { duration: '2m', target: 500 },

        // Phase 3: Extreme load
        { duration: '2m', target: 1000 },

        // Phase 4: BREAKING POINT
        { duration: '2m', target: 2000 },

        // Phase 5: BEYOND LIMITS
        { duration: '1m', target: 3000 },

        // Phase 6: RECOVERY — does it recover?
        { duration: '2m', target: 100 },

        // Phase 7: Cool down
        { duration: '30s', target: 0 },
    ],

    thresholds: {
        http_req_duration: ['p(95)<10000'],   // More lenient — stress test
        http_req_failed: ['rate<0.30'],        // Up to 30% failures expected
        login_success: ['rate>0.50'],          // At least 50% should succeed
    },
};

export default function () {
    // Random user
    const user = Math.random() < 0.8 ? USERS.employee : USERS.admin;

    group('Login', function () {
        const loginPage = http.get(`${BASE_URL}/login`);
        if (loginPage.status !== 200) {
            errorCount.add(1);
            loginSuccess.add(false);
            return;
        }

        const csrfToken = extractCsrfToken(loginPage.body);
        if (!csrfToken) {
            errorCount.add(1);
            loginSuccess.add(false);
            return;
        }

        const loginRes = http.post(`${BASE_URL}/login`, {
            email: user.email,
            password: user.password,
            _token: csrfToken,
        }, { redirects: 5 });

        const ok = check(loginRes, {
            'login ok': (r) => r.status === 200,
        });
        loginSuccess.add(ok);
        if (!ok) errorCount.add(1);
    });

    sleep(Math.random() * 1.5 + 0.5);

    // Hit various pages
    group('Pages', function () {
        const pages = [
            '/employee/dashboard',
            '/employee/attendance',
            '/employee/leaves',
            '/employee/profile',
        ];

        const page = pages[Math.floor(Math.random() * pages.length)];
        const start = Date.now();
        const res = http.get(`${BASE_URL}${page}`);
        pageLoadTime.add(Date.now() - start);

        const ok = check(res, {
            [`${page} loads`]: (r) => r.status === 200,
        });
        if (!ok) errorCount.add(1);
    });

    sleep(Math.random() * 1 + 0.5);

    // Logout
    http.post(`${BASE_URL}/logout`, null, { redirects: 5 });

    sleep(Math.random() * 0.5);
}
