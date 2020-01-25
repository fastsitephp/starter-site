<?php
namespace App\Controllers;

use FastSitePHP\Application;
use FastSitePHP\Lang\I18N;
use FastSitePHP\Lang\L10N;

class AuthDemo
{
    /**
     * Route '/:lang/auth-demo'
     *
     * Demo page that is only displayed if the user is logged-in.
     * This example is defined on a route that uses a filter function
     * to either grant access or display the login screen.
     */
    public function get(Application $app, $lang)
    {
        // Load JSON Language File
        I18N::langFile('auth-demo', $lang);

        // Get the Authenticated User
        // This is set from [App\Middleware\Auth->hasAccess()]
        //
        // Because the user is set to [$app->locals] it is also
        // available from [$app->render()] as the variable [$user].
        $user = $app->locals['user'];

        // Show expire time using date/time formatting with the user's
        // selected language (L10N - Localization).
        //
        // Optionally the timezone will be set if defined in system config.
        // The timezone could also be hard-coded, example:
        //    $l10n->timezone('America/Los_Angeles');
        //
        // See full timezone list here:
        //    https://www.php.net/manual/en/timezones.php
        $expires = null;
        $timezone = null;
        if (isset($user['exp'])) {
            $l10n = new L10N();
            $l10n->locale($lang);
            $timezone = ini_get('date.timezone');
            if (!is_string($timezone) || $timezone === '') {
                $timezone = 'UTC';
            }
            $l10n->timezone($timezone);
            $expires = $l10n->formatDateTime($user['exp']);
        }

        // Render Template
        return $app->render('auth-demo.php', array(
            'nav_active_link' => 'auth-demo',
            'expires' => $expires,
            'timezone' => $timezone,
        ));
    }

    /**
     * Route '/api/data-demo'
     *
     * Demo JSON Service that only returns data if the user is logged-in.
     * This example is defined on a route that uses a filter function
     * to either grant access or display a JSON 401 Response.
     */
    public function getData(Application $app)
    {
        $req = new \FastSitePHP\Web\Request();
        return array(
            'clientIp' => $req->clientIp('from proxy', 'trust local'),
            'userAgent' => $req->userAgent(),
            'user' => $app->locals['user'],
        );
    }
}
