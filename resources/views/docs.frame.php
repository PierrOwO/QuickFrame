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
    padding: 50px;
    font-size: 100%;

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
}
</style>
@endsection

@section('content')

<header class="header">
  <div class="container">
    <span onclick="showSidebar()" class="hamburger-button" id="hamburger-button">|||</span>
    <h1><a href="/">QuickFrame Documentation</a></h1>
    
    <div class="sidebar" id="sidebar" onclick="hideSidebar()" >
      <div class="content" id="sidebar-content" onclick="event.stopPropagation()">
        <div class="nav-header">
          <h3>Navigation</h3>
          <span onclick="hideSidebar()" class="close-btn">&times;</span>
        </div>
        <ul class="links">
          <li><a href="#getting-started">Getting Started</a></li>
          <li><a href="#views&layouts">Views & Layouts</a></li>
          <li><a href="#controllers">Controllers</a></li>
          <li><a href="#css&js">CSS & JS</a></li>
          <li><a href="#auth&sessions">Auth & Sessions</a></li>
          <li><a href="#helpers">Helpers</a></li>
          <li><a href="#migrations">Migrations</a></li>
          <li><a href="#cli">CLI</a></li>
          <li><a href="#testing">Testing</a></li>
          <li><a href="#session">Session</a></li>
          <li><a href="#cache">Cache</a></li>
          <li><a href="#config">Config</a></li>
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
    <p>Controllers are the core part of the MVC (Model-View-Controller) architecture. They handle user requests, interact with models, and return views or other responses.</p>

    <h3>Where are controllers located?</h3>
    <p>Controllers live in the <code style="display: inline-block;">app/Controllers/</code> directory. Each controller is a PHP class grouping methods (actions) that correspond to different functions or endpoints in your application.</p>

    <h3>Main responsibilities of a controller</h3>
    <ul>
      <li>Receive and process HTTP requests.</li>
      <li>Interact with models (fetching, saving data).</li>
      <li>Pass data to views.</li>
      <li>Handle application business logic.</li>
      <li>Manage redirects and HTTP responses (like JSON, file downloads).</li>
    </ul>

    <h3>How to return a view from a controller?</h3>
    <p>Controllers usually return a view with data. Example:</p>
    <pre><code class="language-php">
public function home()
{
    $data = [
        'title' => 'Home Page',
        'items' => ['apple', 'banana', 'pear']
    ];
    return view('home', $data);
}
    </code></pre>
    <p>The <code style="display: inline-block;">view()</code> function loads the view template and passes the data to it.</p>

    <h3>Example of a simple controller</h3>
    <pre><code class="language-php">
namespace App\Controllers;

class HomeController
{
    public function index()
    {
        $message = "Welcome to the home page!";
        return view('home.index', ['message' => $message]);
    }
}
    </code></pre>

    <h3>Best practices</h3>
    <ul>
      <li><strong>Single responsibility:</strong> Keep your controller focused on handling application logic, avoid direct database queries (leave that to models).</li>
      <li><strong>Use dependency injection:</strong> Inject services into controllers instead of creating them inside methods.</li>
      <li><strong>Avoid bloated controllers:</strong> Move complex operations to service classes or models.</li>
      <li><strong>Write tests for controller methods:</strong> This improves maintainability and reliability.</li>
    </ul>

    <h3>Error handling in controllers</h3>
    <p>Controllers should gracefully handle errors and exceptions, e.g., by returning appropriate error pages or JSON error responses for APIs.</p>

    <h3>Middleware and extensions</h3>
    <p>Controllers can use middleware to run code before or after controller actions, such as authentication, logging, or input validation.</p>
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
    <pre><code>&lt;link rel="stylesheet" href="/build/assets/app.css"&gt;
&lt;script type="module" src="/build/assets/app.js"&gt;&lt;/script&gt;
</code></pre>

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
      <li>Migrations allow you to define and version-control your database schema using PHP classes.</li>
      <li>Create a new migration with:<br>
        <code>php frame make:migration CreateUsersTable</code>
      </li>
      <li>Use <code style="display: inline-block;">php frame migrations:on</code> to enable browser access to the migration interface.</li>
      <li>Use <code style="display: inline-block;">php frame migrations:off</code> to disable browser access to the migration interface.</li>
      <li>Visit <a href="/migrations" target="_blank"><code style="display: inline-block;">/migrations</code></a> in your browser to run or drop migrations manually.</li>
    </ul>

    
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

</script>
@endsection