<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Error 403</title>
  <style>
    body {
      margin: 0;
      background-color: #1e1e1e;
      font-family: system-ui, sans-serif;
      color: #e0e0e0;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
    }

    .message {
      background-color: #2c2c2c;
      border-radius: 10px;
      width: 90%;
      max-width: 480px;
      padding: 2rem;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.4);
      text-align: center;
    }

    .message h1 {
      font-size: 3rem;
      color: #F59E0B;
      margin-bottom: 1rem;
    }

    .message p {
      font-size: 1rem;
      color: #cccccc;
      margin-bottom: 2rem;
    }

    .message button {
      background-color: #F59E0B;
      color: white;
      border: none;
      padding: 0.75rem 1.5rem;
      border-radius: 6px;
      font-size: 1rem;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .message button:hover {
      background-color: #d97706;
    }

    .message button:active {
      background-color: #b45309;
    }
  </style>
</head>
<body>
  <div class="message">
    <h1>Error 403</h1>
    <p>{{ $message }}</p>
    <button onclick="homePage()">Back to home page</button>
  </div>

  <script>
    function homePage() {
      window.location.replace('/');
    }
  </script>
</body>
</html>