@extends('layouts.main')

@section('title', 'Documentation')

@section('styles')
<link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>

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

  html {
  scroll-behavior: smooth;
}
#backToTop {
  display: none;
  position: fixed;
  bottom: 90px;
  right: 40px;
  height: 60px;
  width: 60px;
  font-size: 33px;
  font-weight: 800;
  cursor: pointer;
  border: none;
  background-color: #333;
  color: white;
  border-radius: 60px;
  z-index: 1000;
  opacity: 0.7;
  transition: opacity 0.3s ease;
}
#backToTop:hover {
  opacity: 1;
}


@media (max-width: 1000px) {
 
 
  #backToTop {
    width: 120px;
    height: 120px;
    font-size: 50px;
  }
}


code {
  white-space: pre-wrap;
  word-wrap: break-word;
  overflow-wrap: break-word;
}
.container table{
  margin: auto;
}
.container table td:first-child{
  text-align: left;
}
.container table td:last-child{
  text-align: right;
}
.container h1 a{
  text-decoration: none;
  color: #fff;
}



.sidebar {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0);
  visibility: hidden;
  transition: 0.3s ease;
  z-index: 900;
}

.sidebar.show {
  background-color: rgba(0, 0, 0, 0.5);
  visibility: visible;

}

.sidebar .content {
  position: absolute;
  top: 0;
  left: -250px;
  width: 250px;
  height: 100%;
  background-color: #4F46E5;
  color: white;
  transition: left 0.4s ease;
  padding: 1rem 0;
  box-shadow: 4px 0 12px rgba(0, 0, 0, 0.3);
  overflow: auto;
}

.sidebar.show .content {
  left: 0;
}

.sidebar .nav-header {
  display: flex;
  justify-content: center;
  align-items: center;
  position: relative;
  margin-bottom: 1.5rem;
}

.sidebar .nav-header h3 {
  flex: 1;
  text-align: center;
  font-size: 1.2rem;
}

.sidebar .close-btn {
  position: absolute;
  right: 0.5rem;
  top: 50%;
  transform: translateY(-50%);
  font-size: 1.5rem;
  cursor: pointer;
}

.sidebar .links {
  list-style: none;
  padding: 0;
  margin: 0;
  display: flex;
  flex-direction: column;
  padding-bottom: 50px;
}

.sidebar .links li a {
  display: block;
  padding: 0rem 1rem;
  color: white;
  text-decoration: none;
}

.sidebar .links li a:hover {
  background-color: rgba(255, 255, 255, 0.2);
}

header {
  height: 50px;
  width: 100%;
  position: fixed;
  padding: 0 1rem;
  background-color: #f5f5f5;
  line-height: 50px;

}

header .hamburger-button {
  position: absolute;
  top: 50%;
  left: 0;
  transform: translate(100%, -50%) rotate(90deg);
  font-size: 1.8rem;
  background: none;
  border: none;
  cursor: pointer;
  transition: 0.4s;
}
header .search-box {
  position: absolute;
  top: 50%;
  right: 0;
  transform: translate(-50%, -50%);
  height:40px;
  width:40px;
  background: none;
  border: none;
  cursor: pointer;
  transition: 0.4s;
}
.search-box i{
  font-size: 20px;
}
.search-box .input-box{
  position: absolute;
  background-color: #4F46E5;
  height: auto;
  width: 150px;
  top: 90px;
  left: -140px;
  padding: 0px 10px;
  border-radius: 5px;
  transition: 0.4s;
  opacity: 0;
}
.search-box .input-box.show-input{
  opacity: 1;
  top: 71.5px;
}
.search-box .input-box::after{
  content: "";
  background-color: #4F46E5;
  width: 15px;
  height: 15px;
  position: absolute;
  top: -7.5px;
  right: 15px;
  transform: rotate(45deg);
  z-index: -1;
}
.search-box .input-box input{
  width: 100%;
  height: 25px;
  line-height: 25px;
  border-radius: 2px;
  border: none;
  font-size: 16px;
  z-index: 2;
}
mark {
  background-color: #007bff;
  color: #fff;
  font-weight: bold;
}
header .hamburger-button.rotate90{
  transform: translate(100%, -50%) rotate(180deg);
}
section {
  scroll-margin-top: 80px; 
}
@media (max-width: 1000px) {
  .sidebar .content {
    left: -60%;
    width: 60%;
  }
  .sidebar .content .nav-header h3,
  .sidebar .content .nav-header .close-btn{
    font-size: 250%;
  }
  .sidebar .content .links a{
    padding: 30px;
    font-size: 150%;

  }
  .header{
    height: 100px;
    font-size: 150%;
  }
  .header .hamburger-button{
    font-size: 250%;
  }
  section {
    scroll-margin-top: 130px; 
  }
  .hero{
    margin-top: 50px;
  }
}
</style>
@endsection

@section('content')

<header class="header">
  <div class="container">
    <span onclick="showSidebar()" class="hamburger-button" id="hamburger-button">|||</span>
    <h1><a href="/">QuickFrame Documentation</a></h1>
    <div class="search-box">
      <i id="search-box-icon" onclick="showHideInput()" class='bx bx-search'></i>
      <div id="input-box" class="input-box">
        <input id="search" type="text" placeholder="Search...">
      </div>
    </div>

    <div class="sidebar" id="sidebar" onclick="hideSidebar()" >
      <div class="content" id="sidebar-content" onclick="event.stopPropagation()">
        <div class="nav-header">
          <h3>Navigation</h3>
          <span onclick="hideSidebar()" class="close-btn">&times;</span>
        </div>
        <ul class="links">
          <li><a href="#getting-started">Getting Started</a></li>
          <li><a href="#environment">Environment</a></li>
          <li><a href="#views&layouts">Views & Layouts</a></li>
          <li><a href="#controllers">Controllers</a></li>
          <li><a href="#css&js">CSS & JS</a></li>
          <li><a href="#auth&sessions">Auth & Sessions</a></li>
          <li><a href="#helpers">Helpers</a></li>
          <li><a href="#migrations">Migrations</a></li>
          <li><a href="#seeders">Seeders</a></li>
          <li><a href="#cli">CLI</a></li>
          <li><a href="#testing">Testing</a></li>
          <li><a href="#session">Session</a></li>
          <li><a href="#cache">Cache</a></li>
          <li><a href="#config">Config</a></li>
          <li><a href="#mail">Mail</a></li>
          <li><a href="#pdf">PDF helper</a></li>
          <li><a href="#qrcode">QR Code helper </a></li>
          <li><a href="#barcode">Barcode helper </a></li>
          <li><a href="#carbon">Carbon</a></li>
        </ul>
      </div>
    </div>
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
      <li><strong>Installation:</strong> Clone the repo, set up <code style="display:inline-block;">.env</code>, and run your dev server.</li>
      <li><strong>Structure:</strong> Use familiar folders like <code style="display:inline-block;">app/</code>, <code style="display:inline-block;">routes/</code>, <code style="display:inline-block;">resources/</code>.</li>
      <li><strong>Routing:</strong> Define routes in <code style="display:inline-block;">routes/web.php</code> using <code style="display:inline-block;">Route::get()</code> etc. <br>
        <p>Example:</p>
        <code>Route::get('/', [HomeController::class, 'index']);</code>

        <p><strong>HomeController:</strong></p>

        <code>
public function index() 
{
  return view('home', ['title' => 'Welcome!']);
}</code>

        <p><strong>or JSON response:</strong></p>

        <code>
public function index() 
{
  return response()->json(['data' => $data]);
}</code>
      </li>
    </ul>
  </div>
</section>

<section id="environment" class="docs-section">
  <div class="container">
    <h2>⚙️ Environment</h2>
    <ul>
      <li>
        QuickFrame uses a <code style="display: inline-block">.env</code> file to configure the application environment, database, mail, and session settings.
      </li>
      <li>
        Example <code style="display: inline-block">.env</code> configuration:
        <pre><code>APP_NAME="QuickFrame App"
APP_VERSION="1.0.0"

APP_ENV=development
APP_DEBUG=true
APP_URL=http://localhost:8000
VITE_DEV_SRV_URL=http://localhost:2137

MIGRATIONS_ENABLED=true
SEEDERS_ENABLED=true

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_NAME=quickframe
DB_USER=root
DB_PASSWORD=

MAIL_DRIVER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=no-reply@example.com
MAIL_FROM_NAME=QuickFrame

FTP_USER=
FTP_PASSWORD=
FTP_URL=ftp://your-host.com/app

LOGIN_ATTEMPTS_LIMIT=5
LOCKOUT_TIME=300

SESSION_LIFETIME=1800
SESSION_PATH=/
SESSION_DOMAIN=
SESSION_SECURE=false
SESSION_HTTPONLY=true
SESSION_SAMESITE=Lax</code></pre>
      </li>
      <li>
        Environment variables can be accessed using the <code style="display: inline-block">env('KEY')</code> helper inside your application code.
      </li>
    </ul>
  </div>
</section>

<section id="views&layouts" class="docs-section">
  <div class="container">
    <h2>🧩 Views & Layouts</h2>

    <p>Views in QuickFrame work like Blade templates, using the <code style="display:inline-block;">.frame.php</code> extension. You can use familiar directives:</p>

    <ul>
      <li><code style="display:inline-block;">@extends</code> – to inherit a layout</li>
      <li><code style="display:inline-block;">@section</code> – to define content blocks</li>
      <li><code style="display:inline-block;">@yield</code> – to render sections from child views</li>
      <li><code style="display:inline-block;">@include</code> – to include partials (like headers, footers)</li>
    </ul>
  </div>
</section>

<section id="controllers" class="docs-section">
  <div class="container">
    <h2>🧠 Controllers</h2>
    <p>
      Controllers are the core part of the MVC (Model-View-Controller) architecture.  
      They handle user requests, interact with services and models, and return views or API responses.
    </p>

    <h3>Where are controllers located?</h3>
    <p>
      Controllers live in the <code style="display: inline-block;">app/Controllers/</code> directory.  
      Each controller is a PHP class grouping methods (actions) that correspond to different functions or endpoints in your application.
    </p>

    <h3>Main responsibilities of a controller</h3>
    <ul>
      <li>Receive and process HTTP requests.</li>
      <li>Delegate business logic to <strong>services</strong> or models.</li>
      <li>Pass data to views or format API responses (JSON, XML, etc.).</li>
      <li>Manage redirects and HTTP responses (e.g., file downloads).</li>
      <li>Handle application-level flow and validation.</li>
    </ul>

    <h3>Controller with an auto-generated Service</h3>
    <p>
      When you create a controller using the CLI, you can also generate a matching service.  
      This service is automatically imported and instantiated in the controller, so you can focus on calling its methods.
    </p>
    <pre><code class="language-php">
namespace App\Controllers;

use App\Services\UserService;

class UserController
{
    protected UserService $service;

    public function __construct()
    {
        $this->service = new UserService();
    }

    public function index()
    {
        // Example: fetch users
        $users = $this->service->getAll();
        return view('users.index', ['users' => $users]);
    }

    public function checkData($data)
    {
        $result = $this->service->check($data);

        if (!$result['success']) {
            return response()->json([
                'success' => false,
                'message' => $result['message']
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => $result['message']
        ]);
    }
}
    </code></pre>

    <h3>Benefits of using Services in Controllers</h3>
    <ul>
      <li><strong>Separation of concerns:</strong> Controllers focus on routing and responses, services handle business logic.</li>
      <li><strong>Reusability:</strong> The same service can be used in multiple controllers.</li>
      <li><strong>Easier testing:</strong> You can test services separately from controllers.</li>
      <li><strong>Cleaner code:</strong> Less code inside controllers makes them easier to read.</li>
    </ul>

    <h3>Best practices</h3>
    <ul>
      <li>Use dependency injection to pass services, instead of creating them manually when possible.</li>
      <li>Keep controllers thin — heavy logic belongs in services.</li>
      <li>Validate input before passing it to services.</li>
      <li>Handle exceptions gracefully, returning proper error messages or codes.</li>
    </ul>
  </div>
</section>

<section id="css&js" class="docs-section">
  <div class="container">
    <h2>🎨 CSS & JS</h2>

    <p>Our project uses <strong>Vite</strong> as a modern frontend build tool to efficiently compile and bundle CSS and JavaScript assets.</p>

    <h3>How to manage assets?</h3>
    <ul>
      <li>All your main JavaScript and CSS files should be imported in the <code style="display: inline-block;">resources/js/app.js</code> entry point.</li>
      <li>You can import CSS files directly in JavaScript using <code style="display: inline-block;">import './styles.css'</code> or import frameworks like Tailwind or Bootstrap.</li>
      <li>JavaScript modules can also be imported here and bundled together.</li>
    </ul>

    <h3>Running development and production builds</h3>
    <ul>
      <li><code style="display: inline-block;">npm run dev</code>: Starts a development server with hot module replacement (HMR) for rapid development.</li>
      <li><code style="display: inline-block;">npm run build</code>: Compiles and minifies assets for production, generating optimized files in the <code style="display: inline-block;">public/build</code> directory.</li>
    </ul>

    <h3>How to include assets in your views?</h3>
    <p>If you’re using Vite and the build process, include the compiled assets like this:</p>
    <pre><code class="language-html">&lt;link rel="stylesheet" href="/build/assets/app.css"&gt;
&lt;script type="module" src="/build/assets/app.js"&gt;&lt;/script&gt;</code></pre>

    <h3>Using the <code style="display: inline-block;">asset()</code> helper (alternative)</h3>
    <p>If you're not using Vite, or you prefer a simple method to load static files, QuickFrame provides an <code>asset()</code> helper:</p>
    <pre><code>&lt;link rel="stylesheet" href="&lt;?= asset('css/style.css') ?&gt;"&gt;</code></pre>
    <p>This function automatically appends a version string based on the file’s last modified time. For example:</p>
    <pre><code>&lt;link rel="stylesheet" href="/css/style.css?v=1720308702"&gt;</code></pre>
    <p>This helps avoid caching issues when updating assets.</p>

    <blockquote>
      💡 You can use <code>asset()</code> for any file in your <code>/public</code> directory, such as CSS, JS, images, and fonts.
    </blockquote>

    <h3>When to use <code style="display: inline-block;">asset()</code> vs Vite?</h3>
    <table>
      <thead>
        <tr>
          <th>Scenario</th>
          <th>Recommended method</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>You use Vite with hashed filenames</td>
          <td>Use <code style="display: inline-block;">&#64;vite()</code> or include the files from <code style="display: inline-block;">/build</code></td>
        </tr>
        <tr>
          <td>You don't use Vite or want a simpler setup</td>
          <td>Use the <code style="display: inline-block;">asset()</code> helper</td>
        </tr>
        <tr>
          <td>You load static images, fonts, or favicons</td>
          <td>Use the <code style="display: inline-block;">asset()</code> helper</td>
        </tr>
      </tbody>
    </table>

    <h3>Tips & best practices</h3>
    <ul>
      <li>Manage all frontend dependencies using <code style="display: inline-block;">package.json</code>.</li>
      <li>Organize your JavaScript files into modules inside <code>resources/js/</code>.</li>
      <li>Use environment variables like <code style="display: inline-block;">VITE_API_URL</code> by prefixing with <code style="display: inline-block;">VITE_</code> in your JS code.</li>
      <li>Always rebuild assets with <code style="display: inline-block;">npm run build</code> before deploying to production.</li>
    </ul>
  </div>
</section>

<section id="auth&sessions" class="docs-section">
  <div class="container">
    <h2>🔐 Auth & Sessions</h2>

    <p>This framework uses PHP sessions to securely store user data across requests, making it easy to implement authentication and maintain user state.</p>

    <h3>Session Management</h3>
    <ul>
      <li>Use the <code style="display: inline-block;">session()</code> helper to store, retrieve, and manage session data effortlessly.</li>
      <li>Example to set a session value: <code style="display: inline-block;">session(['user_id' => $user->id])</code>.</li>
      <li>Retrieve session data by calling <code style="display: inline-block;">session('user_id')</code>.</li>
      <li>Sessions persist until the user logs out or the session expires.</li>
    </ul>

    <h3>Authentication Helpers</h3>
    <ul>
      <li>Check if a user is authenticated with the <code style="display: inline-block;">auth()->check()</code> method.</li>
      <li>Get the currently authenticated user via <code style="display: inline-block;">auth()->user()</code>
      (e.g., <code style="display: inline-block;">auth()->user()->name</code>).</li>
      <li>Log users in and out using built-in methods (e.g., <code style="display: inline-block;">auth()->login($user)</code>, <code style="display: inline-block;">auth()->logout()</code>).</li>
      <li>Protect routes or controller methods by verifying authentication status using these helpers.</li>
    </ul>

    <h3>Best Practices</h3>
    <ul>
      <li>Always validate user credentials securely before calling login methods.</li>
      <li>Regenerate session IDs on login to prevent session fixation attacks.</li>
      <li>Use middleware or controller checks to restrict access to authenticated users.</li>
      <li>Clear session data properly on logout to avoid unauthorized access.</li>
    </ul>
  </div>
</section>

<section id="helpers" class="docs-section">
  <div class="container">
    <h2>📦 Helpers</h2>

    <h3>redirect(string $url)</h3>
    <p>Redirects the user’s browser to the specified URL and immediately stops script execution. Example: <code>redirect('/home');</code></p>

    <h3>view(string $view, array $data = [])</h3>
    <p>Renders a view from <code>resources/views</code> with optional data passed as an associative array. Example: <code>view('home', ['user' => $user]);</code></p>

    <h3>asset(string $path): string</h3>
    <p>Generates a URL for a public asset and appends a cache-busting query parameter based on the file's modification time. Example: <code style="display: inline-block;">&lt;img src="&lt;?= asset('images/logo.png') ?&gt;" alt="Logo"></code></p>

    <h3>vite(string|array $entries): string</h3>
    <p>Generates the necessary HTML tags to include Vite-built CSS and JS assets. Supports both development mode (with hot module replacement) and production mode (using <code style="display: inline-block;">manifest.json</code>). Example: <code style="display: inline-block;">&#64;vite('js/app.js');</code></p>

    <h3>csrf_token(): string</h3>
    <p>Returns the current CSRF token stored in the session for form protection. Example:</p>
    <code style="display: inline-block;">$token = csrf_token();</code>

    <h3>csrf_field(): string</h3>
    <p>Returns an HTML hidden input field containing the CSRF token, to include inside forms. Example: </p>
      <code style="display: inline-block; flex-wrap: wrap;">&lt;form method="POST"&gt; &lt;?= csrf_field() ?&gt; &lt;/form&gt;</code>

    <h3>base_path(string $path = ''): string</h3>
    <p>Returns the absolute base path of the project, optionally appending a relative subpath. Example:</p>
    <code style="display: inline-block; flex-wrap: wrap;">$path = base_path('app/Controllers/HomeController.php');</code>

    <h3>response(): Response</h3>
    <p>Returns a new instance of the <code style="display: inline-block;">Response</code> class for managing HTTP responses. Example: </p>
    <code>return response()->json(['success' => true]);</code>
  </div>

  
</section>
<section id="migrations" class="docs-section">
  <div class="container">
    <h2>🗂️ Migrations</h2>
    <ul>
      <li>Migrations allow you to define and version-control your database schema using PHP classes, similar to Laravel.</li>

      <li>Create a new migration with:<br>
        <code style="display: inline-block">php frame make:migration CreateUsersTable</code>
      </li>

      <li>Enable browser-based migration interface:<br>
        <code style="display: inline-block">php frame migrations:on</code>
      </li>

      <li>Disable browser-based migration interface:<br>
        <code style="display: inline-block">php frame migrations:off</code>
      </li>

      <li>Visit <a href="/migrations" target="_blank"><code style="display: inline-block">/migrations</code></a> to run or drop migrations manually via the browser.</li>
    </ul>

    <h3>📄 Example migration</h3>
    <pre><code>
// database/migrations/2025_08_03_000000_create_rooms_table.php

use Support\Vault\Database\Blueprint;
use Support\Vault\Facades\Schema;

return new class {
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('house');
            $table->integer('number');
            $table->string('unique_id')->unique();
            $table->timestamps();

            $table->foreign('house')
                  ->references('unique_id')
                  ->on('houses')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
    </code></pre>

    <h3>📚 Common column types</h3>
    <ul>
      <li><code style="display: inline-block">$table->id()</code> – auto-incrementing BIGINT primary key</li>
      <li><code style="display: inline-block">$table->string('name')</code> – VARCHAR(255)</li>
      <li><code style="display: inline-block">$table->integer('count')</code> – INT</li>
      <li><code style="display: inline-block">$table->boolean('active')</code> – TINYINT(1)</li>
      <li><code style="display: inline-block">$table->text('description')</code> – TEXT</li>
      <li><code style="display: inline-block">$table->timestamps()</code> – adds <code style="display: inline-block">created_at</code> and <code style="display: inline">updated_at</code></li>
    </ul>

    <h3>🔗 Foreign keys</h3>
    <p>
      Foreign key constraints can be added using a fluent interface:
    </p>
    <pre><code class="language-php">
$table->foreign('user_id')
      ->references('id')
      ->on('users')
      ->onDelete('cascade');
    </code></pre>

    <p class="text-muted">
      Foreign keys are automatically applied at the end of the chain – you don’t need to call <code style="display: inline">->apply()</code> manually.
    </p>
  </div>
</section>
<section id="seeders" class="docs-section">
  <div class="container">
    <h2>🌱 Seeders</h2>
    <ul>
      <li>Seeders allow you to populate your database with test or initial data using PHP classes.</li>

      <li>Create a new seeder with:<br>
        <code style="display: inline-block">php frame make:seeder UsersSeeder</code>
      </li>

      <li>Run all seeders:<br>
        <code style="display: inline-block">php frame db:seed</code>
      </li>

      <li>Run a specific seeder class:<br>
        <code style="display: inline-block">php frame db:seed UsersSeeder</code>
      </li>

      <li>Enable browser-based seeders interface:<br>
        <code style="display: inline-block">php frame seeders:on</code>
      </li>

      <li>Disable browser-based seeders interface:<br>
        <code style="display: inline-block">php frame seeders:off</code>
      </li>

      <li>Visit <a href="/seeders" target="_blank"><code style="display: inline-block">/seeders</code></a> to run or show seeders manually via the browser.</li>
    </ul>
      <li>All seeders are stored in the <code style="display: inline-block">/database/seeders</code> directory.</li>
    </ul>

    <h3>📄 Example seeder</h3>
    <pre><code>
// database/seeders/UsersSeeder.php

use App\Models\User;

return new class {
    public function run(): void
    {
        User::create([
            'name' => 'Alice',
            'email' => 'alice@example.com',
            'password' => password_hash('secret', PASSWORD_BCRYPT),
        ]);

        User::create([
            'name' => 'Bob',
            'email' => 'bob@example.com',
            'password' => password_hash('secret', PASSWORD_BCRYPT),
        ]);
    }
};
    </code></pre>

    <p class="text-muted">
      Seeders are run in the order they are defined. You can create composite seeders that call multiple individual seeders using method chaining.
    </p>
  </div>
</section>
<section id="cli" class="docs-section">
  <div class="container">
    <h2>⚡️ CLI</h2>
    <ul>
      <li>Create a new QuickFrame project globally with:<br>
        <pre><code>quickframe new my-app</code></pre>
      </li>
      <li>Start the local development server:<br>
        <code style="display: inline-block;">php frame serve</code> (optional: <code style="display: inline-block;">php frame serve 0.0.0.0 8080</code>)
      </li>
      <li>Generate core files with simple commands:
        <ul>
          <li><code>php frame make:controller ProductController</code></li>
          <li><code>php frame make:model Product</code></li>
          <li><code>php frame make:view products.index</code></li>
          <li><code>php frame make:middleware AuthMiddleware</code></li>
          <li><code>php frame make:helper StringHelper</code></li>
        </ul>
      </li>
      <li>Handling tests
        <ul>
        <li>Create test:
            <pre><code>php frame make:test TestName</code></pre>
          </li>
           <li>Run tests:
            <pre><code>php frame run:test</code></pre>
          </li>
        </ul>
      </li>
      <li>Create a new migration file:<br>
        <pre><code>php frame make:migration CreateProductsTable</code></pre>
      </li>
      <li>Enable browser access to the migration interface:<br>
        <pre><code style="display: inline-block;">php frame migrations:on</code></pre>
      </li>
      <li>Disable browser access to the migration interface:<br>
        <pre><code style="display: inline-block;">php frame migrations:off</code></pre>
      </li>
      <li>Visit <a href="/migrations" target="_blank"><code style="display: inline-block;">/migrations</code></a> in your browser to run or drop migrations manually.</li>
      <li>Check all commands by typing:<br>
        <pre><code style="display: inline-block;">php frame /help</code></pre>
      </li>
    </ul>
  </div>
</section>
<section id="testing" class="docs-section">
  <div class="container">
    <h2>🧪 Testing</h2>
    <ul>
      <li>
        Create a test class in <code style="display: inline">/support/Tests</code>:
        <pre><code>use PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase
{
    public function test_app_name_is_correct()
    {
        $this->assertEquals('QuickFrame', config('app.name'));
    }
}</code></pre>
      </li>
      <li>
        Run all tests with:
        <pre><code>php phpunit.phar support/Tests</code></pre>
      </li>
      <li>
        Or via CLI shortcut:
        <pre><code>php frame run:test</code></pre>
      </li>
      <li>
        Test a single file:
        <pre><code>php phpunit.phar support/Tests/ConfigTest.php</code></pre>
      </li>
      <li>
        Use <code style="display: inline">assert</code> methods from PHPUnit:
        <pre><code>$this->assertEquals($expected, $actual);
$this->assertTrue($value);
$this->assertFalse($value);
$this->assertNull($value);</code></pre>
      </li>
      <li>
        Example output:
        <pre><code>PHPUnit 10.5.48 by Sebastian Bergmann and contributors.

.                                                                   
1 / 1 (100%)

Time: 00:00, Memory: 22.94 MB

OK (1 test, 1 assertion)</code></pre>
      </li>
    </ul>
  </div>
</section>
<section id="session" class="docs-section">
  <div class="container">
    <h2>🔐 Session</h2>
    <p>Session management made simple. The <code style="display: inline;">Session</code> class handles starting sessions, storing and retrieving data, and managing CSRF tokens.</p>
    <ul>
      <li>
        Start a session (usually done automatically):
        <pre><code>Session::start();</code></pre>
      </li>
      <li>
        Put data into session:
        <pre><code>Session::put('user_id', 123);
Session::put('last_activity', time());</code></pre>
      </li>
      <li>
        Retrieve data from session:
        <pre><code>$userId = Session::get('user_id');
$lastActivity = Session::get('last_activity', 0); // default 0 if not set</code></pre>
      </li>
      <li>
        Check if a key exists:
        <pre><code>if (Session::has('user_id')) {
    // user is logged in
}</code></pre>
      </li>
      <li>
        Remove data or destroy session:
        <pre><code>Session::forget('user_id'); // remove one key
Session::destroy();              // end session completely</code></pre>
      </li>
      <li>
        CSRF token helpers:
        <pre><code>Session::csrf();           // generate/store token
$token = Session::get('_csrf_token'); // get token value</code></pre>
      </li>
    </ul>
    <p>Using <code style="display: inline;">Session</code> ensures consistent session handling and security features like CSRF protection.</p>
  </div>
</section>
<section id="cache" class="docs-section">
  <div class="container">
    <h2>⚡ Cache</h2>
    <ul>
      <li>
        Store data in the cache using:
        <pre><code>cache()->put('key', 'value', 10); // 10 minutes</code></pre>
      </li>
      <li>
        Retrieve data from the cache:
        <pre><code>$value = cache()->get('key');</code></pre>
      </li>
      <li>
        Check if a cache key exists:
        <pre><code>if (cache()->has('key')) {
    // do something
}</code></pre>
      </li>
      <li>
        Remove a value from the cache:
        <pre><code>cache()->forget('key');</code></pre>
      </li>
      <li>
        Clear the entire cache (use with caution):
        <pre><code>cache()->clear();</code></pre>
      </li>
      <li>
        Cached data is stored in:
        <pre><code>/storage/cache/</code></pre>
      </li>
      <li>
        Cache can be used for:
        <ul>
          <li>⚙️ Configuration caching</li>
          <li>🗺️ Routing table</li>
          <li>🧠 Query results</li>
          <li>📦 API responses</li>
        </ul>
      </li>
    </ul>

    <h3>🧩 Practical Example</h3>
    <p>Cache settings loaded from the database:</p>
    <pre><code>// In your controller or service:
$settings = cache()->remember('site_settings', 60, function () {
    return DB::table('settings')->pluck('value', 'key')->toArray();
});

// Usage:
$siteName = $settings['site_name'] ?? 'QuickFrame';</code></pre>
    <p>This avoids hitting the database on every request.</p>
  </div>
</section>
<section id="config" class="docs-section">
  <div class="container">
  <h2>⚙️ Config</h2>
  <ul>
    <li>
      Get data from config files:
      <pre><code>use Support\Vault\Foundation\Config;

$name = Config::get('app.name');          // "QuickFrame"
$url = Config::get('app.url');            // "http://localhost:8000"
$driver = Config::get('database.driver'); // "mysql"</code></pre>
    </li>
    <li>
      Or simpler (with helper function):
      <pre><code>$name = config('app.name');          // "QuickFrame"
$url = config('app.url');            // "http://localhost:8000"
$driver = config('database.driver'); // "mysql"</code></pre>
    </li>
  </ul>
</div>
</section>
<section id="mail" class="docs-section">
  <div class="container">
    <h2>📧 Mail</h2>
    <ul>
      <li>
        QuickFrame uses the <code style="display: inline-block">PHPMailer</code> library for sending emails.
      </li>
      <li>
        Send a simple email:
        <pre><code>use Support\Mail\Mail;

$mail = Mail::to('user@example.com')
    ->subject('Hello!')
    ->body('Welcome to QuickFrame');

if ($mail->send()) {
    echo "Mail sent!";
} else {
    echo "Error: " . $mail->getError();
}</code></pre>
      </li>
      <li>
        Send an email with an attachment:
        <pre><code>use Support\Mail\Mail;
use Support\Vault\Sanctum\Storage;

$mail = Mail::to('user@example.com')
    ->subject('Invoice')
    ->body('Please find the invoice attached.')
    ->attach(Storage::path('invoices/2025-08.pdf'));

if ($mail->send()) {
    echo "Mail sent!";
} else {
    echo "Error: " . $mail->getError();
}</code></pre>
      </li>
      <li>
        Example SMTP settings in <code style="display: inline-block">.env</code> :
        <pre><code>MAIL_DRIVER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=no-reply@example.com
MAIL_FROM_NAME=QuickFrame</code></pre>
      </li>
    </ul>
  </div>
</section>

<section id="pdf" class="docs-section">
  <div class="container">
    <h2>📄 PDF</h2>
    <ul>
      <li>
        QuickFrame uses the <code style="display: inline-block">TCPDF</code> library to generate PDF documents.
      </li>
      <li>
        Generate a simple PDF:
        <pre><code>use TCPDFWrapper\PDF;

$html = '&lt;h1&gt;Hello PDF&lt;/h1&gt;&lt;p&gt;This is a sample PDF.&lt;/p&gt;';

PDF::new()
    ->author('Piotr')
    ->title('Sample PDF')
    ->addPage('P', 'A4')
    ->content($html)
    ->output('sample.pdf', 'D'); // 'I' = inline, 'D' = download</code></pre>
      </li>
    </ul>
  </div>
</section>

<section id="qrcode" class="docs-section">
  <div class="container">
    <h2>🔲 QR Code</h2>
    <ul>
      <li>
        QuickFrame uses the <code style="display: inline-block">QRCode</code> helper (chillerlan/php-qrcode) to generate QR codes.
      </li>
      <li>
        Generate a QR code:
        <pre><code>use QRCode\QRCode;

QRCode::new('https://quickframe.pieterapps.pl')
    ->scale(4)
    ->margin(2)
    ->bgColor('#ffffff')
    ->fgColor('#000000')
    ->size('200px')
    ->render();</code></pre>
      </li>
    </ul>
  </div>
</section>

<section id="barcode" class="docs-section">
  <div class="container">
    <h2>📇 Barcode</h2>
    <ul>
      <li>
        QuickFrame uses the <code style="display: inline-block">Barcode</code> helper (Picqer\Barcode) to generate 1D barcodes.
      </li>
      <li>
        Generate a barcode:
        <pre><code>use Barcode\Barcode;

Barcode::new('123456789012')
    ->type('C128')
    ->width(2)
    ->height(60)
    ->showText(true)
    ->render();</code></pre>
      </li>
    </ul>
  </div>
</section>

<section id="carbon" class="docs-section">
  <div class="container">
    <h2>🗓️ Carbon</h2>
    <ul>
      <li>
        QuickFrame uses the <code style="display: inline-block">Carbon</code> library for date and time manipulation.
      </li>
      <li>
        Basic examples:
        <pre><code>use Carbon\Carbon;

echo Carbon::now()
echo Carbon::now()->format('Y-m-d H:i:s')
echo Carbon::now()->format('d/m/Y')
echo Carbon::now()->format('l, d F Y')
echo Carbon::now()->addDays(7)
echo Carbon::now()->subWeeks(2)
echo Carbon::now()->addMonths(1)->format('d/m/Y')
echo Carbon::now()->isWeekend() ? 'Weekend' : 'Weekday'
echo Carbon::now()->gt(Carbon::parse('2025-12-25')) ? 'Christmas has come' : "It's not Christmas yet"
echo Carbon::now()->addMinutes(90)->diffForHumans()
echo Carbon::parse('2025-12-31')
echo Carbon::create(2025, 12, 31, 23, 59, 59)
echo Carbon::now('Europe/Warsaw')
echo Carbon::now()->setTimezone('America/New_York')</code></pre>
      </li>
    </ul>
  </div>
  <a href="/" class="btn-primary">← Back to Home</a>
</section>


<button id="backToTop" title="Back to top">↑</button>
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
const sidebarContent = document.getElementById('sidebar-content');
const sidebar = document.getElementById('sidebar');
const HamburgerBtn = document.getElementById('hamburger-button');

function showSidebar(){
  HamburgerBtn.classList.add('rotate90');
    sidebar.classList.add('show');
    sidebarContent.classList.add('show');
 }
 function hideSidebar(){
   sidebar.classList.remove('show');
   sidebarContent.classList.remove('show');
   HamburgerBtn.classList.remove('rotate90');
 }
var inputShowed = false;
function showHideInput(){
  const inputBox = document.getElementById('input-box');
  const searchIcon = document.getElementById('search-box-icon');
  const searchInput = document.getElementById('search');
  if(!inputShowed){
    inputShowed = true;
    inputBox.classList.add('show-input');
    searchIcon.classList.remove('bx-search');
    searchIcon.classList.add('bx-x');
    searchInput.focus();
  }else{
    inputShowed = false;
    inputBox.classList.remove('show-input');
    searchIcon.classList.remove('bx-x');
    searchIcon.classList.add('bx-search');
    searchInput.value = "";
    searchInput.dispatchEvent(new Event("keyup"));

  }
}
document.getElementById("search").addEventListener("keyup", function () {
    const value = this.value.trim().toLowerCase();
    const sections = document.querySelectorAll("section");

    let firstVisibleFound = false;

    sections.forEach(section => {
        section.innerHTML = section.innerHTML.replace(/<mark>(.*?)<\/mark>/gi, '$1');

        const text = section.textContent.toLowerCase();
        const isMatch = text.includes(value);

        section.style.display = isMatch ? "" : "none";
        section.style.marginTop = "";

        if (isMatch) {
            if (value.length > 0) {
                const regex = new RegExp(`(${value})`, 'gi');
                highlightMatches(section, regex);
            }

            if (!firstVisibleFound) {
                section.style.marginTop = "80px";
                firstVisibleFound = true;
            }
        }
    });
});

function highlightMatches(element, regex) {
    for (const node of element.childNodes) {
        if (node.nodeType === 3) { 
            const match = node.nodeValue.match(regex);
            if (match) {
                const span = document.createElement("span");
                span.innerHTML = node.nodeValue.replace(regex, '<mark>$1</mark>');
                node.replaceWith(span);
            }
        } else if (node.nodeType === 1 && node.childNodes.length) {
            highlightMatches(node, regex);
        }
    }
}
</script>
@endsection