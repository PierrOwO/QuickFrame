# 📦 QuickFrame Project Template

This is the default project template used by [QuickFrame installer](https://github.com/PierrOwO/quickframe-installer), a simple PHP micro-framework with a CLI tool.

## 🚀 Getting Started

After installing the QuickFrame CLI, you can create a new project using:

```bash
quickframe new myApp
```

Your project will be created in:  
**Linux/macOS**: `/Users/<username>/QuickFrame/myApp`  
**Windows**: `C:\Users\<username>\QuickFrame\myApp`

## 📂 Structure

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
├── support/
│   └── ...
└── frame
```

## ⚙️ CLI Commands

Inside the project root, you can use:

```bash
php frame serve
```

Starts a local server (default: `localhost:8000`)

### 🛠 Generators

```bash
php frame make:controller Example
php frame make:model Product
php frame make:middleware AuthCheck
php frame make:helper Formatter
php frame make:view homepage
```

## 📡 Requirements

- PHP 8.1+
- Git (for initial project scaffolding)
- `public/index.php` file is required to run the local server.

## 🔧 Development

To extend CLI commands or stub files, check the `support/` directory.
