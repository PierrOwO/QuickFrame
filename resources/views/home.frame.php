@extends('layouts.main')
@section('title', 'QuickFrame – Lightweight PHP Framework with Custom Routing and Views')
@section('styles')
<style>
  section {
    margin-bottom: 100px;
  }
  .login-register{
    position: absolute;
    top:0;
    right: 0;
    padding: 15px;
  }
  .login-register a{
    text-decoration: none;
    color: white;
  }
  .login-register a:hover{
    color: #f2f2f2;
  }
  .login-register a:last-child{
    margin-left: 15px;
  }

</style>
@endsection

@section('content')
<header class="header">
  <div class="container">
    <div class="login-register">
      <a href="/auth/register">Register</a>
      <a href="/auth/login">Login</a>
    </div>
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
@endsection