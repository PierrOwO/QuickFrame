<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <title>QuickFrame – Lightweight PHP Framework with Custom Routing and Views</title>
    <meta name="description" content="QuickFrame is a simple, lightweight PHP framework featuring routing, controllers, sessions, and Blade-like views. Perfect for small projects and learning." />
    <meta name="keywords" content="QuickFrame, PHP framework, routing, sessions, custom framework, lightweight framework" />
    <meta name="author" content="Piotr Miłoś" />
    
    @vite('js/app.js')
   
@yield('styles')
</head>
<body>
<main>
    @yield('content')
  </main>
<footer class="footer">
  <div class="container">
    <p>&copy; 2025 QuickFrame by PierrOwO. MIT License. <a href="https://github.com/PierrOwO/quickframe">GitHub</a></p>
  </div>
</footer>
@yield('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const _token = $('meta[name="csrf-token"]').attr('content');
        console.log('csrf token: ' + _token);
    });
</script>
</body>
</html>
