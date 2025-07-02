@extends('layouts.main')

@section('title', 'About QuickFrame')

@section('styles')
<style>
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
  footer {
    position: fixed;
    bottom: 0;
    width: 100%;
  }
  
</style>
@endsection

@section('content')
<header class="header">
  <div class="container">
    <h1>About QuickFrame</h1>
    <nav>
      <a href="/">Home</a>
      <a href="/docs">Docs</a>
      <a href="https://github.com/PierrOwO/quickframe" target="_blank">GitHub</a>
      <a href="/about">About</a>
    </nav>
  </div>
</header>

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
    <li><strong>Simple and Minimal:</strong> Focus on writing your application logic without complex setup.</li>
    <li><strong>Modern Tooling:</strong> Integration with Vite allows fast frontend development with ES modules.</li>
    <li><strong>Flexible Views:</strong> Uses a Blade-like templating system with `.frame.php` files for easy layout management.</li>
  </ul>

  <h3>Who is it for?</h3>
  <p>
    QuickFrame is ideal for developers who want a small, efficient PHP framework without the overhead of larger frameworks.
    Whether you’re building a simple site or a fast prototype, QuickFrame offers a clean foundation.
  </p>

  <a href="/" class="btn-primary">← Back to Home</a>
</section>
@endsection