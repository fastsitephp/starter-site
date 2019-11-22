<?php
namespace App\Controllers;

use FastSitePHP\Application;
use FastSitePHP\Lang\I18N;

class Resources
{
    /**
     * Route function for URL '/:lang/resources'
     * 
     * @param Application $app
     * @param string $lang
     * @return string
     */
    public function get(Application $app, $lang)
    {
        // Load JSON Language File
        I18N::langFile('resources', $lang);
        $i18n = $app->locals['i18n'];

        // Link list
        $links = [
            [
                'url' => "https://www.fastsitephp.com/{$lang}/quick-reference",
                'title' => $i18n['quick_ref'],
            ],
            [
                'url' => "https://www.fastsitephp.com/{$lang}/examples",
                'title' => $i18n['examples'],
            ],
            [
                'url' => "https://www.fastsitephp.com/{$lang}/documents",
                'title' => $i18n['docs'],
            ],
            [
                'url' => "https://www.fastsitephp.com/{$lang}/api",
                'title' => $i18n['api'],
            ],
        ];

        // Render a PHP Template and return the results
        return $app->render('resources.php', [
            'nav_active_link' => 'resources',
            'links' => $links,
        ]);
    }
}