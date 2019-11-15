<?php
// This script is the main entry point for the app. Routes are defined here and
// in other PHP files loaded from here. This script and gets loaded from the file
// [public\index.php].

// ------------------------------------------------------------------
// Classes used in this file. Classes are not loaded unless used.
// ------------------------------------------------------------------

use FastSitePHP\Lang\I18N;

// --------------------------------------------------------------------------------------
// Site Configuration
// By default FastSitePHP does not require any site configuration in order to run.
// Config is used for this site to allow template rendering and language translations.
// --------------------------------------------------------------------------------------

// General Application Settings
$app->controller_root = 'App\Controllers';
$app->middleware_root = 'App\Middleware';
$app->template_dir = __DIR__ . '/Views/';
$app->header_templates = '_header.php';
$app->footer_templates = '_footer.php';
$app->error_template = 'error.php';
$app->not_found_template = 'error.php';

// Show detailed errors if desired.
// By default detailed errors will only show on localhost.
//
// $app->show_detailed_errors = true;

// Translation Settings
$app->config['I18N_DIR'] = __DIR__ . '/../app_data/i18n';
$app->config['I18N_FALLBACK_LANG'] = 'en';
I18N::setup($app);

// ----------------------------------------------------------------------------
// Routes
// FastSitePHP provides a number of different methods of defining routes.
// The code below provides several different examples.
// ----------------------------------------------------------------------------

// Home Page - Redirect using the Default Language
//
// This route is defined as a callback function (Closure in PHP).
// Defining routes with callback functions allows for fast prototyping
// and works well when minimal logic is used. As code grows in size it
// can be organized into controller classes.
//
$app->get('/', function() use ($app) {
    $app->redirect($app->rootUrl() . 'en/');
});

// Home Page
$app->get('/:lang', function($lang) use ($app) {
    // Load JSON Language File
    I18N::langFile('home-page', $lang);

    // Render a PHP Template and return the results
    return $app->render('home-page.php', [
        'nav_active_link' => 'home',
    ]);
});

// Define routes that point to specific Controllers and Methods. The optional
// config option 'controller_root' is used to specify the root class path.
// The two format options are 'class' and 'class.method'. When using only
// class name then the route function [route(), get(), post(), put(), etc]
// will be used for the method name of the matching controller.
//
$app->get('/:lang/resources', 'Resources');
$app->get('/:lang/lorem-ipsum', 'LoremIpsumDemo');
$app->get('/:lang/lorem-ipsum/data', 'LoremIpsumDemo.getData');

// Example of an 500 error page. Because a filter function is used this will
// only run from localhost. See the [Middleware] directory for the source of
// the filter function 'Env.isLocalhost'. Example URL if running locally:
//     http://localhost:3000/public/site/example-error
$app->get('/site/example-error', function() {
    throw new \Exception('Example Error');
})
->filter('Env.isLocalhost');

// Load additional route files if the requested URL matches.
//
// This feature can be used to limit the number of routes that are loaded
// for each request on a site with many pages and allows for code to be
// organized into smaller related files.
//
// When specifying an optional condition (3rd parameter) the file will only
// be loaded if the condition returns [true]. In this example with [sysinfo] routes
// when using the [Env.isLocalhost] function the routes will only be loaded if the user
// is requesting the page from localhost. If the request is coming from someone on
// the internet then a 404 Response 'Page not found' would be returned.
//
$app->mount('/sysinfo/', 'routes-sysinfo.php', 'Env.isLocalhost');
