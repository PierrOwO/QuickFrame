<template>
  <Header :title="title"/>

<section class="header-section">
  <div class="container">
    <h2>Minimalist PHP framework with Vite</h2>
    <p>Build fast and simple web apps without unnecessary dependencies.</p>
    <a href="/docs" class="btn-primary">Start now</a>
  </div>
</section>

<section class="features">
  <div class="container features-grid">
    <div class="feature-card">
      <h3>🔧 MVC-ready</h3>
      <p>A clean structure based on controllers, models, and views.</p>
    </div>
    <div class="feature-card">
      <h3>⚡ Vite + JS</h3>
      <p>Lightning-fast asset loading with Vite and ES Modules.</p>
    </div>
    <div class="feature-card">
      <h3>🚀 CLI </h3>
      <p>Global CLI for installer 'quickframe' and per-project CLI 'php frame' for fast development and code generation.</p>
    </div>
    <div class="feature-card">
      <h3>📦 Zero Composer</h3>
      <p>No Composer required – works out of the box after download.</p>
    </div>
    <div class="feature-card">
      <h3>🧩 Extendable</h3>
      <p>Add Vue, Tailwind CSS, Alpine.js or any frontend tool – your stack, your choice.</p>
    </div>
    <div class="feature-card">
      <h3>💾 Efficient Caching</h3>
      <p>Built-in simple caching mechanism to speed up your app without extra dependencies.</p>
    </div>
    <div class="feature-card">
      <h3>
        <svg width="20" height="20" viewBox="0 0 261 226" xmlns="http://www.w3.org/2000/svg">
          <path d="M0 0h60l70 120 71-120h60L130 225z" fill="#41B883"/>
          <path d="M60 0h40l30 52 30-52h40L130 150z" fill="#35495E"/>
        </svg> 
        Vue</h3>
      <p>QuickFrame comes with Vue 3 pre-installed and fully configured, so you can start building components right away.</p>
    </div>
    <div class="feature-card">
      <h3>📚 Expandable Libraries & helpers</h3>
      <p>Built-in Helpers (Zip, Upload) and extendable Libraries such as Carbon give you powerful tools out of the box — and you can easily add your own.</p>
    </div>
    <div class="feature-card">
      <h3>📁 Storage</h3>
      <p>
        QuickFrame makes file handling incredibly simple.
        Just call disk() to access any storage disk you’ve configured.
        Upload files, read content, create folders, or delete items with clean, expressive methods.
        And if you need more — you can add your own disks in seconds.
      </p>
    </div>
  </div>
</section>

<section class="cta">
  <div class="container" style="text-align:center;">
    <h2>Start a project in under 1 minute</h2>
    <p>Install QuickFrame globally and build apps with zero config.</p>
    <p style="margin-top: 10px;">
      Want more? Easily add Vue, Tailwind, Alpine, or use built-in database migrations with
      <code style="display:inline-block;">php frame migrations:on</code>.
      Learn more in the <a href="/docs#migrations">migration docs</a>.
    </p>
    <p>Create new project by using code below</p>
   <code>quickframe new my-app</code>
    <a href="https://github.com/PierrOwO/quickframe-installer" class="btn-primary">Install now</a>
  </div>
</section>
</template>

<script setup>
import { ref } from 'vue';
import Header from '../ui/Header.vue';


const title = ref('QuickFrame')
</script>

<style scoped>
  .container {
    max-width: 960px;
    margin: 0 auto;
    padding: 1rem 1.5rem;
  }
  section {
    margin-bottom: 100px;
  }
  .header-section {
    text-align: center;
    padding: 4rem 1rem;
  }
  .header-section h2 {
    font-size: 2.5rem;
    margin-bottom: 1rem;
  }
  .features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 2rem;
  }
  .feature-card {
    background: white;
    padding: 1.5rem;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgb(0 0 0 / 0.1);
    flex: 1;
    text-align: center;
    transition: 0.25s;
  }
  .feature-card:hover{
    transform: scale(0.95);
  }
  .btn-primary {
    display: inline-block;
    margin-top: 20px;
    padding: 10px 18px;
    background-color: #007bff;
    color: white;
    border-radius: 5px;
    text-decoration: none;
  }
  .btn-primary:hover {
    background-color: #0056b3;
  }
  code {
    display: block;
    padding: 8px;
    background-color: #eee;
    border-radius: 4px;
    margin-bottom: 12px;
    white-space: pre;
    font-family: Consolas, monospace;
  }

  p {
    margin: 8px 0;
  }
</style>