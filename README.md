# 📦 QuickFrame Framework

QuickFrame is a lightweight PHP micro-framework inspired by Laravel.  
It was built with simplicity and accessibility in mind — especially for *shared or budget hosting environments* where SSH access is not available.  

With QuickFrame, you can build dynamic PHP web applications even on servers that don't support Composer or command-line tools.

➡️ **Installer repository**: [quickframe-installer](https://github.com/PierrOwO/quickframe-installer)  
➡️ **Status**: Actively developed 🚧
➡️ **Status**: 🔗 https://quickframe.pieterapps.pl

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

# QuickFrame CLI & FTP Deployment Guide

## Available QuickFrame Commands

### Core
- `serve`  
  Start the local development server
- `serve IP PORT`  
  Start server with custom IP and port
- `--version`  
  Show current QuickFrame version
- `-v`  
  Short version of `--version`

### Generators
- `make:controller Name`  
  Create a new controller class
- `make:model Name`  
  Create a new model class
- `make:middleware Name`  
  Create a new middleware class
- `make:helper Name`  
  Create a new global helper function
- `make:view Name`  
  Create a Blade-like view file
- `make:migration Name`  
  Create a new migration class
- `make:seeder Name`  
  Generate a new seeder class

### Migrations
- `migrations:on`  
  Enable browser migration interface
- `migrations:off`  
  Disable browser migration interface

### Seeders
- `db:seed`  
  Run all seeders from `/database/seeders`
- `db:seed Name`  
  Run a specific seeder class
- `seeders:on`  
  Enable browser seeder interface
- `seeders:off`  
  Disable browser seeder interface

### FTP Deployment
- `ftp:init`  
  Initialize Git FTP
- `ftp:push`  
  Deploy using Git FTP

---

## FTP Commands Requirements

The commands:

- `php frame ftp:init`
- `php frame ftp:push`

only work if you have **git-ftp** installed.

### Linux / macOS

Make sure you have `git ftp` installed, for example:

```bash
brew install git-ftp       # macOS with Homebrew
sudo apt install git-ftp   # Ubuntu/Debian Linux
```
### Windows

## Option 1: Use WSL (Windows Subsystem for Linux)

Due to environment limitations, it’s best to run git ftp inside the Windows Subsystem for Linux (WSL) environment.

If you don’t have WSL installed yet, open PowerShell as Administrator and run:

```bash
wsl --install
```

After installing WSL and restarting your PC, you can use git ftp commands via WSL.

## Option 2: Use Git Bash Terminal

If you have Git for Windows installed, you may also use git ftp from the Git Bash terminal — just make sure git ftp is correctly installed and accessible in that environment.

⸻

Note:
QuickFrame automatically detects git ftp either from WSL or the standard shell (like Git Bash).
To avoid issues, ensure git ftp works correctly in at least one of these environments.

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

## 🌱 Seeders

QuickFrame supports class-based seeders similar to Laravel:

- Create a seeder:
  ```bash
  php frame make:seeder UsersTableSeeder
  ```
- Run a specific seeder:
  ```bash
  php frame db:seed UsersTableSeeder
  ```
- Run all seeders:
  ```bash
  php frame db:seed
  ```
- Enable browser access to the seeder panel:
  ```bash
  php frame seeders:on
  ```
- Visit [`/seeders`](http://localhost:8000/seeders) in your browser to manually run seeders.
- Disable seeder access:
  ```bash
  php frame seeders:off
  ```
  
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