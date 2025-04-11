import { createRouter, createWebHistory } from 'vue-router';
import Home from './pages/Home.vue';

// صفحات کاربران
import TemplateUser from './pages/users/Template.vue';
import IndexUser from './pages/users/Index.vue';
import ShowUser from './pages/users/Show.vue';

// صفحات پست‌ها
import TemplatePost from './pages/posts/Template.vue';
import IndexPost from './pages/posts/Index.vue';
import ShowPost from './pages/posts/Show.vue';
import CreatePost from './pages/posts/Create.vue';
import EditPost from './pages/posts/Edit.vue';
import EditGrade from './pages/grades/Edit.vue';

// صفحه ورود
import Login from './Pages/Auth/Login.vue'; // صفحه ورود

// بررسی اینکه آیا کاربر لاگین کرده است
function isAuthenticated() {
    return localStorage.getItem('token') !== null;
}

const routes = [
    { path: '/', name: 'home', component: Home },
    { path: '/login', name: 'login', component: Login }, // صفحه ورود

    {
        path: '/students', name: 'userTemplate', component: TemplateUser, children: [
            { path: '', name: 'users', component: IndexUser },
            { path: ':user/grades', name: 'userId', component: ShowUser },
            { path: ':user/grades/:courseTeacherId/edit', name: 'gradeEdit', component: EditGrade },
        ],
        beforeEnter: (to, from, next) => {
            if (isAuthenticated()) {
                next(); // اجازه دسترسی به صفحه
            } else {
                console.log('.....')
                next({ name: 'login' }); // هدایت به صفحه ورود در صورت عدم احراز هویت
            }
        }
    },
    // روت‌های پست‌ها
    {
        path: '/posts', name: 'postTemplate', component: TemplatePost, children: [
            { path: '', name: 'posts', component: IndexPost },
            { path: ':id', name: 'postId', component: ShowPost },
            { path: 'create', name: 'createPost', component: CreatePost },
            { path: 'edit/:id', name: 'editPost', component: EditPost }
        ]
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes
});
router.beforeEach((to, from, next) => {
    const publicPages = ['/login']; // صفحاتی که نیاز به لاگین ندارند
    const authRequired = !publicPages.includes(to.path);
    const isLoggedIn = !!localStorage.getItem('token');

    if (authRequired && !isLoggedIn) {
        return next({ path: '/login' });
    }

    // اگر لاگین کرده یا صفحه عمومی بود
    next();
});

export default router;
