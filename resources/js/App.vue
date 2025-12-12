<script setup>
    import { ref } from 'vue';
    import Home from './components/views/Home.vue';
    import About from './components/views/About.vue';
    import Documentation from './components/views/Documentation.vue';
    import Login from './components/views/Login.vue';
    import Register from './components/views/Register.vue';
    import Dashboard from './components/views/Dashboard.vue';
    import Footer from './components/ui/Footer.vue';
    import BackToTop from './components/ui/BackToTop.vue'
    
    const props = defineProps({
        year: {
            type: Number,
            default: 2024
        },
        view: {
            type: String,
            required: true
        },
    });

    const currentView = props.view
    const bgColor = ref('#007bff')
    if(currentView == 'home' || currentView == 'about'  || currentView == 'docs')
    {
        bgColor.value = '#f8f8f8f8'
    }
    
</script>
<template>
    <div id="app-wrapper" :style="{ backgroundColor: bgColor }">
        <div class="body">
            <div id="app">
                <Login v-if="currentView === 'login'"/>
                <Register v-if="currentView === 'register'"/>
                <Dashboard v-if="currentView === 'dashboard'"/>
                <Home v-if="currentView === 'home'"/>
                <Documentation v-if="currentView === 'docs'"/>
                <About v-if="currentView === 'about'"/>
            </div>
        </div>
        <Footer :year="year" />
        <BackToTop />
    </div>
    
</template>
<style scoped>
#app-wrapper {
  display: flex;
  flex-direction: column;
  min-height: 100vh; 
}

.body {
  flex: 1;
}
</style>