@extends('layouts.main')

@section('title', 'Documentation')

@section('styles')
<style>
.docs-section {
  padding: 0px 20px;
}
.docs-section h2 {
  font-size: 1.5rem;
  font-weight: bold;
  text-align: center;
}
.docs-section .container ul{
   list-style: disc;
}
.docs-section .container h3,
.docs-section .container p,
.docs-section .container pre {
  text-align: left;
  margin-left: 20px;
}
.docs-section{
    max-width: 800px;
    margin: auto;
    margin-bottom: 25px;
    padding-top: 25px; 

}
.docs-section .container{
    border-radius: 8px;
    background-color: white;
    box-shadow: 0 2px 8px rgb(0 0 0 / 0.1);
}
  code{
    padding: 4px;
    background-color: rgb(224, 224, 224);
    border-radius: 3px;

  }
  html {
  scroll-behavior: smooth;
}
#backToTop {
  display: none;
  position: fixed;
  bottom: 40px;
  right: 40px;
  padding: 10px 15px;
  font-size: 18px;
  cursor: pointer;
  border: none;
  background-color: #333;
  color: white;
  border-radius: 5px;
  z-index: 1000;
  opacity: 0.7;
  transition: opacity 0.3s ease;
}
#backToTop:hover {
  opacity: 1;
}
.header nav a {
   
    padding: 5px 5px;
    font-size: 14px;
  }
</style>
@endsection

@section('content')

<header class="header">
  <div class="container">
    <h1>QuickFrame</h1>
    <nav>
      <a href="#getting-started">Getting Started</a>
      <a href="#views&layouts">Views & Layouts</a>
      <a href="#controllers">Controllers</a>
      <a href="#css&js">CSS & JS</a>
      <a href="#auth&sessions">Auth & Sessions</a>
      <a href="#helpers">Helpers</a>
    </nav>
  </div>
</header>

<section  class="hero">
  <div class="container">
    <h2>Documentation</h2>
    <p>Learn how to use QuickFrame and build modern PHP applications easily.</p>
  </div>
</section>

<section id="getting-started" class="docs-section">
  <div class="container">
    <h2>🚀 Getting Started</h2>
    <ul>
      <li><strong>Installation:</strong> Clone the repo, set up `.env`, and run your dev server.</li>
      <li><strong>Structure:</strong> Use familiar folders like `app/`, `routes/`, `resources/`.</li>
      <li><strong>Routing:</strong> Define routes in `routes/web.php` using `Route::get()` etc.</li>
    </ul>
  </div>
</section>

<section id="views&layouts" class="docs-section">
  <div class="container">
    <h2>🧩 Views & Layouts</h2>
    <ul>
      <li>Use `.frame.php` files that work like Blade templates.</li>
      <li>Use `@extends`, `@section`, `@yield`, `@include` to build UI.</li>
    </ul>
  </div>
</section>

<section id="controllers" class="docs-section">
  <div class="container">
    <h2>🧠 Controllers</h2>
    <ul>
      <li>Controllers live in `app/Controllers/` and handle logic.</li>
      <li>Return views with data like: `return view('home', [...])`.</li>
    </ul>
  </div>
</section>

<section id="css&js" class="docs-section">
  <div class="container">
    <h2>🎨 CSS & JS</h2>
    <ul>
      <li>Use Vite to build and load assets.</li>
      <li>Import CSS/JS inside `resources/js/app.js`.</li>
      <li>Run `npm run dev` or `npm run build` for production.</li>
    </ul>
  </div>
</section>

<section id="auth&sessions" class="docs-section">
  <div class="container">
    <h2>🔐 Auth & Sessions</h2>
    <ul>
      <li>Store data with PHP sessions using `session()` helper.</li>
      <li>Check auth with `auth()` helper functions.</li>
    </ul>
  </div>
</section>

<section id="helpers" class="docs-section">
  <div class="container">
    <h2>📦 Helpers</h2>

    <h3>redirect($url)</h3>
    <p>Redirects the browser to the given URL and stops the script execution.</p>
    <pre><code>redirect('/home');</code></pre>

    <h3>view(string $view, array $data = [])</h3>
    <p>Renders a view from <code>resources/views</code> with optional data passed as an associative array.</p>
    <pre><code>view('home', ['user' => $user]);</code></pre>

    <h3>asset(string $path): string</h3>
    <p>Generates a URL to a public asset, appending a cache-busting query parameter based on the file modification time.</p>
    <pre><code>&lt;img src="&lt;?= asset('images/logo.png') ?&gt;" alt="Logo"></code></pre>

    <h3>vite(string|array $entries): string</h3>
    <p>Generates HTML tags for including Vite-built CSS and JS assets. Works in dev mode (with hot-reloading) and production mode (using manifest.json).</p>
    <pre><code>&lt;?= vite('js/app.js') ?&gt;</code></pre>
    <pre><code>&lt;?= vite(['js/app.js', 'css/app.css']) ?&gt;</code></pre>

    <h3>csrf_token()</h3>
    <p>Returns the current CSRF token stored in the session for form protection.</p>
    <pre><code>$token = csrf_token();</code></pre>

    <h3>csrf_field()</h3>
    <p>Returns an HTML hidden input field with the CSRF token for inclusion inside forms.</p>
    <pre><code>&lt;form method="POST"&gt;</code></pre>
    <pre><code>&lt;?= csrf_field() ?&gt;</code></pre>
    <pre><code>&lt;/form&gt;</code></pre>

    <h3>base_path(string $path = ''): string</h3>
    <p>Returns the absolute base path of the project, optionally appending a relative subpath.</p>
    <pre><code>$path = base_path('app/Controllers/HomeController.php');</code></pre>

    <h3>response(): Response</h3>
    <p>Returns a new instance of the <code>Response</code> class for managing HTTP responses.</p>
    <pre><code>return response()->json(['success' => true]);</code></pre>

  </div>
  <a href="/" class="btn-primary">← Back to Home</a>
</section>
<button id="backToTop" title="Back to top">
  ↑ Top
</button>
@endsection
@section('scripts')
<script>
    const backToTopButton = document.getElementById('backToTop');

window.addEventListener('scroll', () => {
  if (window.scrollY > 300) {  
    backToTopButton.style.display = 'block';
  } else {
    backToTopButton.style.display = 'none';
  }
});

backToTopButton.addEventListener('click', () => {
  window.scrollTo({
    top: 0,
    behavior: 'smooth'  
  });
});

</script>
@endsection