import { createApp } from 'vue'
import App from '../js/Pages/App.vue'
import router from './router.js'
import '../css/app.css';
import 'bootstrap/dist/js/bootstrap.bundle.min.js'
import 'bootstrap/dist/css/bootstrap.min.css';
import 'datatables.net';


const app = createApp(App)
app.use(router)
app.mount('#app')
