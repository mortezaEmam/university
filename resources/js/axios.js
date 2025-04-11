// src/plugins/axios.js
import axios from 'axios';

// ساخت نمونه axios
const api = axios.create({
    baseURL: '/api', // می‌تونی اینو طبق نیازت تغییر بدی
    headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
    }
});

// اضافه کردن هدر Authorization به همه درخواست‌ها
api.interceptors.request.use(config => {
    const token = localStorage.getItem('token');
    if (token) {
        config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
}, error => {
    return Promise.reject(error);
});

// هندل کردن پاسخ‌های غیرمجاز
api.interceptors.response.use(response => {
    return response;
}, error => {
    if (error.response && error.response.status === 401) {
        // اگر توکن معتبر نباشه یا منقضی شده باشه، می‌تونی به صفحه لاگین هدایت کنی
        window.location.href = '/login';
    }
    return Promise.reject(error);
});

export default api;
