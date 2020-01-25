<?php

namespace App\Middleware;

use FastSitePHP\Application;

/**
 * CORS Middleware (Cross-Origin Resource Sharing)
 *
 * This class is included with the starter site and provides a template with
 * common options for CORS Services. Use this class with route filter callback
 * functions so that the OPTIONS request can be handled.
 *
 * This class is desinged to be easy to use without making changes and also
 * easy to modify if you need to handle custom CORS options for your site.
 *
 * @link https://developer.mozilla.org/en-US/docs/Web/HTTP/Access_control_CORS
 * @link http://www.html5rocks.com/en/tutorials/cors/
 * @link http://www.w3.org/TR/cors/
 * @link http://www.w3.org/TR/cors/#access-control-allow-origin-response-header
 * @link https://en.wikipedia.org/wiki/Cross-origin_resource_sharing
 */
class Cors
{
    /**
     * Allow all sites to submit [Authorization] and [Content-Type] headers.
     * This function can be used for JSON or GraphQL Services were the API
     * or Web Service is on a different host or domain from the main site.
     *
     * This function adds the following headers:
     *     Access-Control-Allow-Origin: {Client-Origin}
     *     Access-Control-Allow-Headers: Authorization, Content-Type
     *     Access-Control-Allow-Credentials: true
     *
     * If the client does not submit an origin then the following is used:
     *     Access-Control-Allow-Origin: *
     *
     * @param Application $app
     */
    public function acceptAuth(Application $app)
    {
        if (isset($_SERVER['HTTP_ORIGIN']) && $_SERVER['HTTP_ORIGIN'] !== 'null') {
            $app->cors(array(
                'Access-Control-Allow-Origin' => $_SERVER['HTTP_ORIGIN'],
                'Access-Control-Allow-Headers' => 'Authorization, Content-Type',
                'Access-Control-Allow-Credentials' => 'true',
            ));
        } else {
            $app->cors('*');
        }
    }
}
