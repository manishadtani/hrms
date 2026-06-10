// ============================================
// EMS k6 Load Test — Shared Configuration
// ============================================

export const BASE_URL = __ENV.BASE_URL || 'http://localhost';

// Test user credentials — multiple users for realistic load
export const USERS = {
    admin: { email: 'admin@ems.com', password: 'password123' },
    manager: { email: 'manager@ems.com', password: 'password123' },
    employee: { email: 'yasheue55@gmail.com', password: 'password123' },
};

// Pool of 50 test employees for load testing
export const TEST_EMPLOYEES = [];
for (let i = 1; i <= 50; i++) {
    TEST_EMPLOYEES.push({
        email: `testuser${i}@ems.com`,
        password: 'password123',
    });
}

// Get a random test user (weighted: 80% employees, 15% manager, 5% admin)
export function getRandomUser() {
    const rand = Math.random();
    if (rand < 0.80) {
        // Pick random employee from pool
        const idx = Math.floor(Math.random() * TEST_EMPLOYEES.length);
        return TEST_EMPLOYEES[idx];
    } else if (rand < 0.95) {
        return USERS.manager;
    } else {
        return USERS.admin;
    }
}

// Thresholds — what's acceptable
export const THRESHOLDS = {
    http_req_duration: ['p(95)<3000'],  // 95% requests under 3s
    http_req_failed: ['rate<0.05'],     // Less than 5% errors
    http_reqs: ['rate>10'],             // At least 10 req/s
};

// Extract CSRF token from Laravel page HTML
export function extractCsrfToken(html) {
    // Try meta tag first
    const metaMatch = html.match(/meta\s+name="csrf-token"\s+content="([^"]+)"/);
    if (metaMatch) return metaMatch[1];

    // Try hidden input
    const inputMatch = html.match(/name="_token"\s+value="([^"]+)"/);
    if (inputMatch) return inputMatch[1];

    // Try reversed attribute order
    const inputMatch2 = html.match(/value="([^"]+)"\s+name="_token"/);
    if (inputMatch2) return inputMatch2[1];

    return null;
}

// Login helper
import http from 'k6/http';

export function login(user) {
    const loginPage = http.get(`${BASE_URL}/login`);
    const csrfToken = extractCsrfToken(loginPage.body);

    if (!csrfToken) {
        console.error('❌ Could not extract CSRF token');
        return null;
    }

    const loginRes = http.post(`${BASE_URL}/login`, {
        email: user.email,
        password: user.password,
        _token: csrfToken,
    }, { redirects: 5 });

    return { csrfToken, loginRes };
}
