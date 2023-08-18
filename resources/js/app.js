import './bootstrap';
import '../sass/app.scss';
import Router from '@/router'

import { createApp } from 'vue';
import App from "./components/layouts/App.vue";

const app = createApp(App)
app.use(Router)
app.mount('#app')
