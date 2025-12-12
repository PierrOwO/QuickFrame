<template>
  <Header :title="title"/>
  <section class="about-container">
  <div class="about-header">
    <h2>What is QuickFrame?</h2>
  </div>
  <p>
    QuickFrame is a lightweight PHP framework designed to make building web applications fast and easy.
    It leverages modern tools like Vite for asset bundling and hot module replacement during development.
  </p>

  <h3>Key Features</h3>
  <ul>
    <li><strong>Simple and Minimal:</strong> Focus on writing your application logic without complex setup or overhead.</li>
    <li><strong>Modern Tooling:</strong> Integrated with Vite for fast frontend development using ES modules and hot reloading.</li>
    <li><strong>Flexible Views:</strong> Blade-like templating with <code style="display: inline;">.frame.php</code> files for straightforward layout management.</li>
    <li><strong>Extensible:</strong> Easily add Vue, Tailwind CSS, Alpine.js, or any frontend tool to fit your project.</li>
    <li><strong>Zero Dependencies:</strong> No Composer required — ready to use right after download.</li>
  </ul>

  <h3>Who is it for?</h3>
  <p>
    QuickFrame is perfect for developers seeking a small, efficient PHP framework without the complexity of larger solutions.
    Whether you're building a simple website or a rapid prototype, QuickFrame provides a clean, solid foundation.
  </p>

  <a href="/" class="btn-primary">← Back to Home</a>
</section>
</template>

<script setup>
import { ref } from 'vue';
import Header from '../ui/Header.vue';
const title = ref('About QuickFrame')
</script>

<style scoped>
.about-container {
    max-width: 800px;
    margin: 40px auto;
    padding: 0 20px;
    line-height: 1.6;
    font-family: Arial, sans-serif;
    color: #333;
  }
  .about-header {
    text-align: center;
    margin-bottom: 30px;
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
  code{
    background-color: #dcdcdc;
    padding: 0.4rem;
    border-radius: 0.2rem;
  }
</style>