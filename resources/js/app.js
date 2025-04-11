import '../css/app.css';
import './bootstrap';
import App from '../js/Pages/App.vue';
import router from './router.js';
import 'bootstrap/dist/js/bootstrap.bundle.min.js'
import 'bootstrap/dist/css/bootstrap.min.css';
import { createApp, h } from 'vue';


const app = createApp(App)
app.use(router)
app.mount('#app');
