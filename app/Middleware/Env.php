<?php

namespace App\Middleware;

use FastSitePHP\Application;
use FastSitePHP\Environment\DotEnv;
use FastSitePHP\Net\IP;
use FastSitePHP\Web\Request;

/**
 * Environment Middleware
 * 
 * This class is included with the starter site and provides a template with
 * common options for environment middleware. Modify this class as needed
 * for your site.
 * 
 * Example usage that only allows a route if the user is on a local network
 * and then loads a [.env] file prior to the route running:
 * 
 *     $app->get('/url', 'Controller')
 *         ->filter('Env.isLocalNetwork')
 *         ->filter('Env.loadDotEnv');
 */
class Env
{
    /**
     * Return true if the request is running from localhost '127.0.0.1' (IPv4)
     * or '::1' (IPv6) and if the web server is also running on localhost.
     * 
     * @return bool
     */
    public function isLocalhost()
    {
        $req = new Request();
        return $req->isLocal();
    }

    /**
     * Return true if the web request is coming a local network.
     * (for example 127.0.0.1 or 10.0.0.1).
     * 
     * @return bool
     */
    public function isLocalNetwork()
    {
        $req = new Request();
        $user_ip = $req->clientIp();
        $ip_list = IP::privateNetworkAddresses();
        return IP::cidr($ip_list, $user_ip);
    }

    /**
     * Return true if the web request is coming a local network and
     * and a Proxy Server such as a Load Balancer is being used.
     * 
     * @return bool
     */
    public function isLocalFromProxy()
    {
        $req = new Request();
        $user_ip = $req->clientIp('from proxy');
        $ip_list = IP::privateNetworkAddresses();
        return IP::cidr($ip_list, $user_ip);
    }

    /**
     * Loads environment variables from a [.env] file into [getenv()] and [$_ENV].
     * 
     * @param Application $app
     */
    public function loadDotEnv(Application $app)
    {
        $file_path = $app->config['APP_DATA'] . '/.env';
        DotEnv::loadFile($file_path);

        // Required variables can be checked when loading the file and are
        // recommended to avoid unexpected errors in case they are missing:
        /*
        $required_vars = ['JWT_KEY', 'DB_CONNECTION_STRING'];
        DotEnv::loadFile($file_path, $required_vars);
        */
    }
}
