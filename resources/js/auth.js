import $ from 'jquery';
window.$ = $;
window.jQuery = $;
import axios from 'axios';
window.axios = axios;
axios.defaults.headers.common['X-CSRF-TOKEN'] =
    document.querySelector('meta[name="csrf-token"]').getAttribute('content');
import './auth/login.js';
import './auth/register.js';