@extends('layouts.main')
@section('title', 'Home page')
@section('styles')
<style>

  section {
    margin-bottom: 100px; 
  }
</style>
@endsection
@section('content')
<header class="header">
  <div class="container">
    <h1>QuickFrame</h1>
    <nav>
      <a href="/">Home</a>
      <a href="/docs">Docs</a>
      <a href="https://github.com/PierrOwO/quickframe" target="_blank">GitHub</a>
      <a href="/about">About</a>
    </nav>
  </div>
</header>

<section class="hero">
  <div class="container">
  <h2>Lightweight PHP framework with Vite</h2>
  <p>A simple and fast way to create web applications without unnecessary ballast.</p>
    <a href="/docs" class="btn-primary">Start now</a>
  </div>
</section>

<section class="features">
  <div class="container features-grid">
    <div class="feature-card">
    <h3>Modularity</h3>
<p>Easy to create components and extend functionality.</p>
</div>
<div class="feature-card">
<h3>Performance</h3>
<p>Optimized code and fast resource loading with Vite.</p>
</div>
<div class="feature-card">
<h3>Ease of use</h3>
<p>Minimal configuration, quick start and clear documentation.</p>
</div>
  </div>
</section>
@endsection
