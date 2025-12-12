import { createApp } from 'vue'
import App from './App.vue'

const root = document.getElementById('app')
const initialView = root.dataset.view
const currentYear = new Date().getFullYear();

createApp(App, { 
    view: initialView,
    year: Number(currentYear)
}).mount('#app')