<?php

declare(strict_types=1);

/*
 *---------------------------------------------------------------
 * APPLICATION BOOTSTRAP
 *---------------------------------------------------------------
 *
 * This file bootstraps CodeIgniter to run as an application.
 * Try to do this with as little dependencies as possible to
 * keep the main application as independent as possible.
 *
 * Apps in CI4 are independent.
 *
 * The following global constants are available throughout the app:
 *
 *  FCPATH   - The path to the front controller (this file)
 *  ROOTPATH - The root path of the project
 *  APPPATH  - The path to the app directory
 *  WRITEPATH - The path to the writable directory
 *  TESTPATH - The path to the tests directory
 *  CIPATH   - The path to the system directory
 *  VENDORPATH - The path to the vendor directory
 */

/*
 *---------------------------------------------------------------
 * DEFINE THE DIRECTORIES
 *---------------------------------------------------------------
 */
// Path to the front controller (this file's directory)
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);

// The path to the "app" directory
define('APPPATH', realpath(__DIR__ . '/../app') . DIRECTORY_SEPARATOR);

// The path to the "writable" directory
define('WRITEPATH', realpath(__DIR__ . '/../writable') . DIRECTORY_SEPARATOR);

// The path to the project root
define('ROOTPATH', realpath(__DIR__ . '/..') . DIRECTORY_SEPARATOR);

// The path to the "vendor" directory
define('VENDORPATH', realpath(ROOTPATH . 'vendor') . DIRECTORY_SEPARATOR);

/*
 *---------------------------------------------------------------
 * BOOTSTRAP THE APPLICATION
 *---------------------------------------------------------------
 * This process sets up the path constants, loads and registers
 * our autoloader, along with Composer's, loads our constants
 * and fires up an environment-specific bootstrapping.
 */
// Ensure the current directory is pointing to the front controller's directory
if (getcwd() . DIRECTORY_SEPARATOR !== FCPATH) {
    chdir(FCPATH);
}

// Load our paths config file
// This is the line that might need to be changed, depending on your folder structure.
$pathsConfig = APPPATH . 'Config/Paths.php';
// ^^^ Change this if you move your application folder

require $pathsConfig;

$paths = new Config\Paths();

// Location of the framework bootstrap file.
require rtrim($paths->systemDirectory, '\\/ ') . DIRECTORY_SEPARATOR . 'bootstrap.php';

// Load environment settings from .env files into $_SERVER and $_ENV
require_once SYSTEMPATH . 'Config/DotEnv.php';
(new CodeIgniter\Config\DotEnv(ROOTPATH))->load();

$app = Config\Services::codeigniter();
$app->initialize();
$context = is_cli() ? 'php-cli' : 'web';
$app->setContext($context);
$app->run();
