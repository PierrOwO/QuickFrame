<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <meta name="description" content="QuickFrame is a simple, lightweight PHP framework featuring routing, controllers, sessions, and Blade-like views. Perfect for small projects and learning." />
    <meta name="keywords" content="QuickFrame, PHP framework, routing, sessions, custom framework, lightweight framework" />
    <meta name="author" content="Piotr Miłoś" />
    
    @vite('js/app.js')
    <style>
      body {
          margin: 0;
          font-family: Arial, sans-serif;
          background-color: #007bff;
      }
      .main {
        background-color: white;
        width: 60%;
        height: auto;
        padding: 20px;
        margin: auto;
        margin-top: 30px;
        border-radius: 15px;
        box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
      }
      
      .logout {
        position: absolute;
        right: 0;
        top: 0;
        padding: 15px;
        font-size: 22px;
        font-weight: bold;
        color: #ffffff; 
        text-decoration: none;
        transition: 0.25s;
      }
      .logout:hover {
        color: #d1cfcf;
      }
    </style>
</head>
<body>
<main>
      <a class="logout" href="logout">Logout</a>
    <div class="main">
      <h1>Hello there!</h1>
      <h4>Your Name is {{ auth()->user()->name}}</h4>
    </div>
</main>
<footer class="footer">
  <div class="container">
    <p>&copy; 2025 QuickFrame v{{config('app.version')}} by PierrOwO. MIT License. <a href="https://github.com/PierrOwO/quickframe">GitHub</a></p>
  </div>
</footer>
</body>
</html>
