<?php
require_once __DIR__ . '/../support/Vault/Config/autoload.php';
require_once __DIR__ . '/../support/Vault/Foundation/helpers.php';
require_once __DIR__ . '/../support/Vault/Config/routes.php';
$config = loadConfig();

/**
 * File: public/index.php
 *
 * This is the front controller of the application — the single entry point
 * for all HTTP requests. Every request to the application is routed through this file.
 *
 * Responsibilities of this file:
 * - Bootstrap the application
 * - Handle incoming HTTP requests
 * - Dispatch the matched route
 *
 * It typically loads the routing system and any necessary setup before running the app.
 * This setup ensures a clean and centralized flow of control.
 * 
 */