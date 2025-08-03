# 📦 QuickFrame Framework

QuickFrame is a lightweight PHP micro-framework inspired by Laravel.  
It was built with simplicity and accessibility in mind — especially for *shared or budget hosting environments* where SSH access is not available.  

With QuickFrame, you can build dynamic PHP web applications even on servers that don't support Composer or command-line tools.

➡️ **Installer repository**: [quickframe-installer](https://github.com/PierrOwO/quickframe-installer)  
➡️ **Status**: Actively developed 🚧
➡️ **Live preview**: 🔗 https://quickframe.pieterapps.pl

---

## 🚀 Getting Started

Once the QuickFrame CLI is installed, you can create a new project by running:

```bash
quickframe new myApp
```

Your project will be created in:  
**Linux/macOS**: `/Users/<username>/myApp`  
**Windows**: `C:\Users\<username>\Desktop\myApp`

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
│   ├── css/
│   ├── js/
│   └── views/
├── routes/
│   ├── api.php
│   ├── auth.php
│   └── web.php
├── storage/
├── support/
│   └── ...
├── .env
├── frame
├── LICENSE
├── package-lock.json
├── package.json
└── vite.config.js
```

---

## ⚙️ CLI Commands

From the project root, you can run:

```bash
php frame serve
```

Starts a local development server at `http://localhost:8000`

---

### 🛠 Generators

QuickFrame includes generators for common elements:

```bash
php frame make:controller Example
php frame make:model Product
php frame make:middleware AuthCheck
php frame make:helper Formatter
php frame make:view homepage
php frame make:migration CreateUsersTable
```

---

## 🗂️ Migrations

QuickFrame supports class-based migrations similar to Laravel:

- Create a migration:
  ```bash
  php frame make:migration CreateUsersTable
  ```
- Enable browser access to the migration panel:
  ```bash
  php frame migrations:on
  ```
- Visit [`/migrations`](http://localhost:8000/migrations) in your browser to manually apply/drop migrations.
- Disable migration access:
  ```bash
  php frame migrations:off
  ```

Migrations use an internal Blueprint system to define tables, columns, foreign keys and constraints.

---

## 💡 VS Code Integration

To enable syntax highlighting and Blade features for `.frame.php` view files in **Visual Studio Code**, add this to your User Settings (`settings.json`):

```json
"files.associations": {
  "*.frame.php": "blade"
}
```

You can find this setting by opening the Command Palette and searching for:  
`Preferences: Open User Settings (JSON)`

---

## 📡 Requirements

- PHP 8.1+
- Git (used by the installer to fetch templates)
- A web server with support for `public/index.php`

---

## 🎯 Why QuickFrame?

Laravel is powerful, but it requires a modern server environment with Composer and terminal access (SSH).  
QuickFrame removes these limitations — it runs out-of-the-box on traditional shared hosting platforms using only FTP.

Perfect for:

- Shared hosting deployments
- Lightweight/internal web apps
- Laravel-style devs who need simpler, portable projects

---

## 🔧 Development

QuickFrame is under active development

Feel free to contribute, submit issues, or suggest improvements!