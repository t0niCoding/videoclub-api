import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
// test 
import HelloWorld from './components/HelloWorld.vue'

import './bootstrap';

createApp(App).use(router).mount('#app')
