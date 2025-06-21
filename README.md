
# 📦 QuickFrame Framework

QuickFrame is a lightweight PHP micro-framework inspired by Laravel. It was built with simplicity and accessibility in mind — especially for *shared or budget hosting environments* where SSH access is not available. With QuickFrame, you can build dynamic PHP web applications even on servers that don't support Composer or command-line tools.

➡️ **Installer repository**: [quickframe-installer](https://github.com/PierrOwO/quickframe-installer)  
➡️ **Status**: Actively developed 🚧

---

## 🚀 Getting Started

Once the QuickFrame CLI is installed, you can create a new project by running:

```bash
quickframe new myApp
```

Your project will be created in:  
**Linux/macOS**: `/Users/<username>/myApp`  
**Windows**: `C:\QuickFrame\myApp`

---

## 📂 Project Structure

```
myApp/
├── app/
│   ├── Controllers/
│   ├── Helpers/
│   ├── Middleware/
│   └── Models/
├── public/
│   └── index.php
├── resources/
│   └── views/
├── routes/
│   └── web.php
├── storage/
├── support/
│   └── ...
├── .env
├── deploy.sh
├── database.sql
└── frame
```

---

## ⚙️ CLI Commands

From the project root, you can run:

```bash
php frame serve
```

Starts a local development server (default: `localhost:8000`)

---

### 🛠 Generators

QuickFrame includes generators for common elements:

```bash
php frame make:controller Example
php frame make:model Product
php frame make:middleware AuthCheck
php frame make:helper Formatter
php frame make:view homepage
```

---

## 📡 Requirements

- PHP 8.1+
- Git (used to fetch project templates)
- `public/index.php` is required to run the local server.

---

## 🎯 Why QuickFrame?

Laravel is powerful, but it requires a modern server environment with terminal access (SSH) and Composer.  
QuickFrame removes this limitation — it runs out-of-the-box on traditional shared hosting platforms that only support basic FTP upload and have no CLI or shell access.

Perfect for:

- Deployments on shared hosting
- Lightweight or internal business apps
- Developers looking for Laravel-style routing and structure in a simpler package

---

## 🔧 Development
QuickFrame currently includes:
 - Lightweight MVC structure
 - Custom router with support for dynamic parameters and middleware
 - Native session support with authentication (login + user session)
 - View rendering system
 - Custom autoloader (no Composer required)
 - Simple CLI installer (frame)
 - Asset helper with cache-busting for CSS/JS

 
QuickFrame is under active development — upcoming features include:
  - CSRF protection
  - Form validation
  - Session and flash message support

Feel free to open issues or contribute with suggestions!
