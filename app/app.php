<?php
// This script is the main entry point for the app. Routes are defined here and
// other PHP files are also loaded from here. This script and gets loaded from
// the file [public\index.php].

// ------------------------------------------------------------------
// Classes used in this file. Classes are not loaded unless used.
// ------------------------------------------------------------------

use FastSitePHP\Lang\I18N;
use FastSitePHP\Web\Response;

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
$app->config['APP_DATA'] = __DIR__ . '/../app_data';

// Show detailed errors if desired.
// By default detailed errors will only show on localhost.
//
// $app->show_detailed_errors = true;

// Translation Settings
$app->config['I18N_DIR'] = __DIR__ . '/../app_data/i18n';
$app->config['I18N_FALLBACK_LANG'] = 'en';
I18N::setup($app);

// Uncomment the following line if desired to prevent
// browsers or client from caching responses:
//
// $app->noCache();

// ----------------------------------------------------------------------------
// Routes
// FastSitePHP provides a number of different methods of defining routes.
// The code below provides several different examples.
// ----------------------------------------------------------------------------

/**
 * Root URL, redirect to the user's default language based the 'Accept-Language'
 * request header. Defaults to 'en = English' if no language is matched.
 *
 * This route is defined as a callback function (Closure in PHP).
 * Defining routes with callback functions allows for fast prototyping
 * and works well when minimal logic is used. As code grows in size it
 * can be organized into controller classes.
 *
 * Unlike JavaScript PHP functions do not have access to variables in the
 * parent scope. The [use] keyword as shown below can be used to pass
 * variables from the parent scope.
 * 
 * The response header [Vary: Accept-Language] is used for Content
 * negotiation to let bots know that the content will change based
 * on language. For example this applies to Googlebot and Bingbot.
 */
$app->get('/', function() use ($app) {
    $res = new Response();
    return $res
        ->vary('Accept-Language')
        ->redirect($app->rootUrl() . I18N::getUserDefaultLang() . '/');

    // If your server does not support `index.php` as a fallback resource but
    // still uses it as the default page you can then use the following:
    /*
    $root_url = $app->rootUrl();
    if (stripos($root_url, 'index.php/') === false) {
        $root_url .= 'index.php/';
    }
    $res = new Response();
    return $res
        ->vary('Accept-Language')
        ->redirect($root_url . I18N::getUserDefaultLang() . '/');
    */
});

/**
 * Home Page
 *
 * The template [home-page.php] exits in the [Views] folder/directory
 * which is specified from the setting [$app->template_dir] near the top
 * of this file. Additionally header and footer templates will be included
 * because they are also defined in the site settings.
 */
$app->get('/:lang', function($lang) use ($app) {
    // Load JSON Language File
    I18N::langFile('home-page', $lang);

    // Render a PHP Template and return the results
    // NOTE - On most versions of PHP (5.4+) you can use `[]` instead of `array()`
    return $app->render('home-page.php', array(
        'nav_active_link' => 'home',
    ));
});

/**
 * Define routes that point to specific Controllers and Methods. The optional
 * config option [controller_root] defined near the top of this file is used
 * to specify the root class namespace.
 *
 * The two format options are 'class' and 'class.method'. When using only
 * class name then the route function [route(), get(), post(), put(), etc]
 * will be used for the method name of the matching controller.
 *
 * Controller Classes are defined in the folder/directory [app/Controllers]
 * because the PHP Autloader maps the [app] directory to the [App] namespace
 * when classes are loaded.
 */
$app->get('/:lang/resources', 'Resources');
$app->get('/:lang/lorem-ipsum', 'LoremIpsumDemo');
$app->get('/:lang/lorem-ipsum/data', 'LoremIpsumDemo.getData');

/**
 * Authentication Demo
 *
 * The page '/:lang/auto-demo' and API route '/api/data-demo' uses a filter
 * function with the Auth Middleware Class from [app/Middleware/Auth.php].
 * When first viewed a login page will be displayed from the filter function.
 * Once logged in and the user has access then they can view the page.
 * The filter function is only called if the requested path matches the route.
 *
 * The provided login page at [app/Views/login-page.php] and App Auth Classes
 * can be used as a starting point for your own site and is designed to work well
 * with standard Websites, Single Page Apps (SPA), and API's.
 *
 * Middleware Classes are defined in the folder/directory [app/Middleware]
 * which is specified from the [$app->middleware_root] setting near the top
 * of this file. [middleware_root] defines the root class namespace.
 */
$app->post('/:lang/auth/login', 'Auth.login');
$app->route('/auth/logout', 'Auth.logout');
$app->get('/:lang/auth-demo', 'AuthDemo')->filter('Auth.hasAccess');

/**
 * The Auth API demo JSON Service can be tested from a HTTP Client
 * or App such as Postman or Postwoman. You can also view it from your
 * browser once you login.
 *
 * To test from an HTTP Client add the following request headers when submitting the request:
 *
 *   Content-Type: application/json
 *   Authorization:  Bearer {access-token}
 *
 * A valid {access-token} can be deteremined from the 'X-Access-Token' Response Header
 * from the Login Service. Full example with the default demo user:
 *
 *   1) First view the API Service without a Login:
 *        GET /api/data-demo
 *      Include Request Header [Content-Type: application/json] for a JSON Response,
 *      or exclude the header to return and HTML Response with login page.
 *      Response Returned:
 *        401 Unauthorized
 *        WWW-Authenticate: Bearer
 *        { "success":false, "authRequired":true }
 *
 *   2) Login:
 *        POST /en/auth/login
 *      Include Requst Header:
 *        Content-Type: application/x-www-form-urlencoded
 *      Include Form Fields:
 *        user: Admin
 *        password: Password123
 *
 *   3) Get Access Token from Response Header:
 *      Response Returned:
 *        X-Access-Token: {{access-token}}
 *        { "success":true }
 *
 *   4) Submit valid API Request:
 *        GET /api/data-demo
 *      Include Request Headers:
 *        Content-Type: application/json
 *        Authorization:  Bearer {{access-token}}
 *      [Content-Type] is not actually needed for a valid response on this
 *      specific route, rather it is included on the invalid response so
 *      that a JSON response will be returned.
 */
$app
    ->get('/api/data-demo', 'AuthDemo.getData')
    ->filter('Cors.acceptAuth')
    ->filter('Auth.hasAccess');

/**
 * Example of an 500 error page. Because a filter function is used this will
 * only run from localhost. See the [Middleware] directory for the source of
 * the filter function 'Env.isLocalhost'. Example URL if running locally:
 *     http://localhost:3000/public/site/example-error
 */
$app->get('/site/example-error', function() {
    throw new \Exception('Example Error');
})
->filter('Env.isLocalhost');

/**
 * Load additional route files if the requested URL matches.
 *
 * This feature can be used to limit the number of routes that are loaded
 * for each request on a site with many pages and allows for code to be
 * organized into smaller files that are related.
 *
 * When specifying an optional condition (3rd parameter) the file will only
 * be loaded if the condition returns [true]. In this example with [sysinfo] routes
 * when using the [Env.isLocalhost] function the routes will only be loaded if the user
 * is requesting the page from localhost. If the request is coming from someone on
 * the internet then a 404 Response 'Page not found' would be returned.
 */
$app->mount('/sysinfo/', 'routes-sysinfo.php', 'Env.isLocalhost');
