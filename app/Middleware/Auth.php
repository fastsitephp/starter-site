<?php

namespace App\Middleware;

use FastSitePHP\Application;
use FastSitePHP\Data\Database;
use FastSitePHP\Data\Validator;
use FastSitePHP\Environment\DotEnv;
use FastSitePHP\Lang\I18N;
use FastSitePHP\Net\Config;
use FastSitePHP\Security\Crypto;
use FastSitePHP\Security\Crypto\Encryption;
use FastSitePHP\Security\Crypto\JWT;
use FastSitePHP\Security\Crypto\SignedData;
use FastSitePHP\Security\Password;
use FastSitePHP\Web\Response;
use FastSitePHP\Web\Request;

/**
 * Auth Middleware
 *
 * This class is included with the starter site and is intended as a starting
 * point and template for authentication and provides a number of options for
 * creating secure sites using authentication.
 *
 * This class can be used as-is without any changes or you can remove features
 * that you do not need to reduce the size of the code. If you intend on using
 * this class with a site that has many users spending time to remove un-needed
 * code is recommended because it’s a good practice as it will help you
 * understand the full security of your site and various security options.
 * A good starting point is to search for "$this->method" and "$method" and
 * remove methods and all related code that you do not use.
 *
 * By default this class uses JSON Web Tokens (JWT) with a 1 hour timeout and
 * session cookie for the storage format. Request and Response headers using a
 * Bearer Token are also included for authentication with API’s and Web Services.
 * In addition to JWT this class supports Signed Cookies, Encrypted Cookies,
 * and PHP Sessions. To change the storage format modify the private [$method]
 * property of this class.
 *
 * A new token/cookie will be sent to the client with each response so that the
 * user can keep browswing the site as long as they remain active within the
 * expiration time.
 *
 * When first used this class will create a [.env] file with secure config settings,
 * a SQLite database for users, and a demo admin user. LDAP can be used for network validation
 * (for example: Windows Active Directory on a Corporate Network) instead of a database
 * by modifying the private [$type] property of this class. To use your own database instead
 * of SQLite search for "connectToDb" to find where SQLite is used and then modify the code.
 *
 * Public functions for routing and for filtering routes:
 *     login($app, $lang)
 *     logout($app)
 *     hasAccess($app)
 *
 * Public functions for editing users in the demo db:
 *     addUser($app, $login, $password)
 *     updateUser($app, $login, $new_password)
 *     deleteUser($app, $login)
 *
 * See also:
 *     setupDemo()
 *     validateDbUser()
 *     validateLdapUser()
 *     How this class is used from [app/app.php], search for "Auth."
 *
 * IMPORTANT - If you end up using this class without making any changes then
 * you MUST change the password on the example Admin user to a secure/strong password.
 * This can be done with a temporary route on your site by copying and modifying the
 * example code below:
 *
 *     $app->get('/admin/update-user', function() use ($app) {
 *         $auth = new \App\Middleware\Auth();
 *         return $auth->addUser($app, 'name', 'password');
 *         return $auth->updateUser($app, 'name', 'new_password');
 *         return $auth->deleteUser($app, 'name');
 *     });
 *
 * Or define routes for a localhost admin user, example:
 *
 *     $app->get('/auth/add/:name/:password', 'Auth.addUser')->filter('Env.isLocalhost');
 *     $app->get('/auth/update/:name/:new_password', 'Auth.updateUser')->filter('Env.isLocalhost');
 *     $app->get('/auth/delete/:name', 'Auth.deleteUser')->filter('Env.isLocalhost');
 */
class Auth
{
    /**
     * Auth Expiration Time
     *
     * Examples:
     *   '+1 hour'
     *   '+20 minutes'
     */
    private $auth_expires = '+1 hour';

    /**
     * Auth Method - Storage format used for the Cookie
     *
     *   jwt = JSON Web Token
     *   csd = Crypto Signed Data
     *   enc = Encryption
     *   ses = PHP Session
     *
     * When using JWT or CSD the browser/client will have the ability to decode
     * and use the User object. This is by design and allows for client apps
     * to perform desired functionality from JavaScript, for example displaying
     * a user name or reading from a list of roles for logic. While clients can
     * view and use the decoded object they cannot tamper with it and if they do
     * it will be rejected by the server when using this class.
     *
     * If using Encryption then the client will not have the ability
     * to view the decoded object.
     *
     * IMPORTANT - If you would like you use PHP Sessions you should make careful
     * consideration regarding the design and security of your site. By default
     * PHP Sessions block additional user requests once [session_start()] is called
     * because PHP locks a cookie storage file on server. This can be solved by
     * calling [session_write_close()] as soon as you no longer need to read or
     * write to session variables. If your site ends up with a lot of traffic
     * and uses PHP Sessions it can cause all users to hang. The other methods
     * of using JWT, CSD, or Encryption with Session Cookies avoids this and are
     * designed to work well with API’s, Websites, and SPA’s. Also if you want to
     * use PHP Session and have multiple servers behind a load balancer then you
     * need to save PHP sessions in a database rather than using the local server.
     */
    private $method = 'jwt';

    /**
     * Auth Type
     *
     * $type = 'db' or 'ldap'
     *
     * A SQLite Demo database is provided by default. LDAP can be used for network
     * validation (for example: Windows Active Directory on a Corporate Network).
     *
     * If using LDAP and [$domain = null], then the domain will be read from the
     * environment. If using LDAP it's recommended to set the domain here otherwise
     * a DNS call to the server will be made on each request.
     *
     * If using LDAP on a Windows Domain you may need to include full domain or email
     * rather than login alone for the user name, example:
     *   user@domain.com
     *   domain\user
     */
    private $type = 'db';
    private $domain = null;

    /**
     * Cookie Setings
     *
     * Using [$cookie_expires = 0] so that the cookie lasts only for the session.
     * It will be cleared when the user closes the browser, however browsers will often
     * keep it longer depending on user settings so timeout is handled by the JWT,
     * Signed Cookie, or logic if using Encryption.
     *
     * Cookie settings are based on PHP options from setcookie():
     *     https://www.php.net/manual/en/function.setcookie.php
     *
     * The default path used is the root path for the site '/'.
     */
    private $cookie_name = 'user';
    private $cookie_path = '/';
    private $cookie_expires = 0;
    private $cookie_domain = '';
    private $cookie_secure = false; // Set to [true] if your site only uses HTTPS
    private $cookie_httponly = false;

    /**
     * Response Header for the Access Token (JWT, Signed Data, or Encryption).
     * API's or Mobile apps can use the Response header to read the Auth token.
     */
    private $res_auth_header = 'X-Access-Token';

    /**
     * Login Page Template and JSON Language file
     */
    private $login_page = 'login-page.php';
    private $i18n_file = 'login-page';

    /**
     * Check if a user has access based on the Request. This function is intended
     * to be used as a route filter function. If the user does not have access
     * this function will return a 401 Unauthorized Response with a login page.
     *
     * If the request header [Content-Type] = 'application/json' and the user does not
     * have access then a 401 JSON Response will returned instead of the login page.
     *
     * @param Application $app
     * @return bool
     */
    public function hasAccess(Application $app)
    {
        // OPTIONS requests happen from CORS when browsers preflight the request
        // so simply exit because the authorization will not be set at this point.
        $req = new Request();
        if ($req->method() === 'OPTIONS') {
            return;
        }

        // If user is authenticated then set app user and return [true]
        $user = $this->getUserFromRequest($app);
        if ($user !== null) {
            $this->setAppUser($app, $user);
            return true;
        }

        // User is not set or token has expired so return a 401 Unauthorized Response

        // For API's and Mobile Apps that submit the request with the
        // [Content-Type: application/json] header return a JSON response.
        if ($req->header('Content-Type') === 'application/json') {
            $res = new Response($app);
            return $res
                ->statusCode(401)
                ->header('WWW-Authenticate', 'Bearer')
                ->json(array('success' => false, 'authRequired' => true));
        }

        // A login page will be returned if the content-type is not json

        // Load language file for the user
        $components = explode('/', $app->requestedPath());
        $lang = $components[1];
        if (!I18N::hasLang($lang)) {
            $lang = $app->config['I18N_FALLBACK_LANG'];
        }
        I18N::langFile($this->i18n_file, $lang);

        // Return login page
        $html = $app->render($this->login_page);
        $res = new Response($app);
        return $res
            ->statusCode(401)
            ->header('WWW-Authenticate', 'Bearer')
            ->clearCookie($this->cookie_name, $this->cookie_path, $this->cookie_domain, $this->cookie_secure, $this->cookie_httponly)
            ->content($html);
    }

    /**
     * Login method. Returns a JSON response for the login page.
     *
     * In the starter site template this is called from the URL:
     *   POST '/:lang/auth/login'
     *
     * @param Application $app
     * @param string $lang
     * @return Response
     */
    public function login(Application $app, $lang)
    {
        $this->setupDemo($app);

        // Scope variables for older versions of PHP.
        // When using newer versions these two variables are not needed
        // and [$this->*] can be used in the closure.
        $auth = $this;
        $type = $this->type;

        // Define Validation Rules
        $v = new Validator();
        $v
            ->addRules(array(
                // The [required] attribute is also handled from the browser
                //    Field,        Title,       Rules
                array('user',       'User',      'required'),
                array('password',   'Password',  'required check-user'),
            ))
            ->customRule('check-user', function($password) use ($app, $lang, $auth, $type) {
                // Check User in either Db or with LDAP depending on settings
                if ($type === 'db') {
                    $is_valid = $auth->validateDbUser($app, $_POST['user'], $password);
                } else { // LDAP
                    $is_valid = $auth->validateLdapUser($_POST['user'], $password);
                }

                // If user or password is invalid return an generic error message
                if (!$is_valid) {
                    I18N::langFile($auth->i18n_file, $lang);
                    return $app->locals['i18n']['login_error'];
                }

                // User is valid
                return true;
            });

        // Validate and return error message if not authenticated
        list($errors, $fields) = $v->validate($_POST);
        if ($errors) {
            $res = new Response($app);
            return $res
                ->json(array(
                    'success' => false,
                    'errorMessage' => implode(', ', $errors),
                ));
        }

        // Generic user object to encode.
        // [roles] is included here as an example. All 3 encoded storage methods
        // [ JWT, Signed Data, Encryption ] allow for any object to be encoded
        // so you can define properties that makes sense for your app or site.
        $user = array(
            'name' => $_POST['user'],
            'roles' => array('admin', 'user'),
        );

        // Return success JSON Response that contains a Cookie and Response Header
        // with the encoded user object (token) or if using PHP Sessions then
        // start a new session.
        switch ($this->method) {
            case 'jwt':
                return $this->loginResponseJWT($app, $user);
            case 'csd':
                return $this->loginResponseCSD($app, $user);
            case 'enc':
                return $this->loginResponseCrypto($app, $user);
            case 'ses':
                return $this->loginResponseSession($app, $user);
            default:
                throw new \Exception('Programming Error - Unknown Method');
        }
    }

    /**
     * Logout and redirect to the site root URL.
     *
     * In the starter site template this is called from the URL:
     *   GET|POST|{ANY} '/auth/logout'
     *
     * When JWT, Signed Cookies, or Encrypted Cookies are used the previously
     * used Access Token will still be valid until it expires (or unless
     * the site config crypto keys or settings are changed). The logout feature
     * is simply intended for websites so a user can logout. As long as HTTPS
     * is used then the previous token cannot be monitored and will be cleared
     * from the browser cache on logout. This is by design because tokens are
     * not invalidated from this class once a user logs out. If you need to track
     * tokens per user and include additional limitations then this would be part
     * of the logic for your app.
     *
     * @param Application $app
     * @return Response
     */
    public function logout(Application $app)
    {
        // If using a PHP Session first destory the session
        $cookie_name = null;
        if ($this->method === 'ses') {
            if (session_status() !== PHP_SESSION_ACTIVE) {
                session_start();
            }
            if (ini_get('session.use_cookies')) {
                $cookie_name = session_name();
            }
            session_destroy();
        } else {
            $cookie_name = $this->cookie_name;
        }

        // Return a response that clears the cookie and redirects to site root URL
        $res = new Response($app);
        if ($cookie_name !== null) {
            $res->clearCookie($cookie_name, $this->cookie_path, $this->cookie_domain, $this->cookie_secure, $this->cookie_httponly);
        }
        return $res->redirect($app->rootUrl());
    }

    /**
     * Add a user to the example SQLite database
     *
     * @param Application $app
     * @param string $login
     * @param string $password
     * @return array
     */
    public function addUser(Application $app, $login, $password)
    {
        $db = $this->connectToDb($app);
        $pw = new Password();
        $hash = $pw->hash($password);
        $sql = 'INSERT INTO users (login, password_hash) VALUES (?, ?)';
        $count = $db->execute($sql, array($login, $hash));
        return array('rows_added' => $count);
    }

    /**
     * Change the password for a user in the example SQLite database
     *
     * @param Application $app
     * @param string $login
     * @param string $new_password
     * @return array
     */
    public function updateUser(Application $app, $login, $new_password)
    {
        $db = $this->connectToDb($app);
        $pw = new Password();
        $hash = $pw->hash($new_password);
        $sql = 'UPDATE users SET password_hash = ? WHERE login = ?';
        $count = $db->execute($sql, array($hash, $login));
        return array('rows_updated' => $count);
    }

    /**
     * Delete a user from the example SQLite database
     *
     * @param Application $app
     * @param string $login
     * @return array
     */
    public function deleteUser(Application $app, $login)
    {
        $db = $this->connectToDb($app);
        $sql = 'DELETE FROM users WHERE login = ?';
        $count = $db->execute($sql, array($login));
        return array('rows_deleted' => $count);
    }

    /**
     * Setup Demo App
     *
     * This function will create a [.env] file and SQLite Database if they are
     * not already created. If you create a real application you will likely want
     * to remove this function or comment out the function calls to it once you
     * have your environment setup.
     *
     * @param Application $app
     */
    private function setupDemo(Application $app)
    {
        // Create DotEnv file at [app_data/.env] if it does not already exist.
        // All 3 possible keys for this demo will be generated.
        // The generated keys are secure and can be used for production sites.
        // In a live site you may only want to keep the key that you need or
        // modify this class to delete un-used code.
        $file_path = $app->config['APP_DATA'] . '/.env';
        if (!is_file($file_path)) {
            $jwt = new JWT();
            $csd = new SignedData();
            $enc = new Encryption();
            $content = 'JWT_KEY=' . $jwt->generateKey() . "\n";
            $content .= 'SIGNING_KEY=' . $csd->generateKey() . "\n";
            $content .= 'ENCRYPTION_KEY=' . $enc->generateKey();
            file_put_contents($file_path, $content);
        }

        // Create a demo SQLite Database at [app_data/users.sqlite], a Users Table, and
        // User for Testing. Another function will use SQL to get and validate the user.
        $this->connectToDb($app);
    }

    /**
     * Connect to the Demo SQLite Database.
     * SQLite will create the file when first accessed.
     */
    private function connectToDb(Application $app)
    {
        $file_path = $app->config['APP_DATA'] . '/users.sqlite';
        $dsn = 'sqlite:' . $file_path;
        $add_user = !is_file($file_path);
        $db = new Database($dsn);
        if ($add_user) {
            // Create [users] Table
            $sql = 'CREATE TABLE users (id INTEGER PRIMARY KEY AUTOINCREMENT, login, password_hash)';
            $db->execute($sql);

            // Add a unique index for the login field
            $sql = 'CREATE UNIQUE INDEX users_login ON users(login)';
            $db->execute($sql);

            // Add a Test User: [Admin / Password123]
            //
            // IMPORTANT - This is for the demo page, if you are keeping this database
            // for a real site you should change the password or delete the user.
            // See class comments for more on this topic.
            //
            // Although the Password is not strong this demo uses provides an example
            // using of a secure storage format - bcrypt using the Password Class.
            // Example of saved hash format:
            //   '$2y$10$ke4br.Dm0c.LntD3NjCPIuJX.GjW2kHqgeUSd9s1YJSztCNKBn0Fa'
            $pw = new Password();
            $login = 'Admin';
            $password = 'Password123';
            $hash = $pw->hash($password);
            $sql = 'INSERT INTO users (login, password_hash) VALUES (?, ?)';
            $db->execute($sql, array($login, $hash));
        }
        return $db;
    }

    /**
     * Validate a user and password using a Database. This example uses the
     * demo SQLite Db that is created by this class and can be easily modified
     * to support other databases.
     *
     * @param Application $app
     * @param string $login
     * @param string $password
     * @return bool
     */
    public function validateDbUser($app, $login, $password)
    {
        $pw = new Password();
        $db = $this->connectToDb($app);

        // Check if the login is valid. [queryValue()] returns null if the record
        // does not exists. If the login is not not found then the password is
        // hashed and verified to cause a slight delay in the response. This can
        // help prevent timing attacks and an attacker is attempting to find
        // valid logins. Basically if the password is not hashed the response
        // would be slightly faster allowing the attacher to know that the login
        // is valid or not. Once an attacker finds a valid login they can move
        // on and attempt at guessing passwords for the login.
        $sql = 'SELECT password_hash FROM users WHERE login = ?';
        $hash = $db->queryValue($sql, array($login));
        if ($hash === null) {
            $known_hash = '$2y$10$ke4br.Dm0c.LntD3NjCPIuJX.GjW2kHqgeUSd9s1YJSztCNKBn0Fa';
            $pw->verify($password, $known_hash);
            return false;
        }

        // Verify the submitted password against the saved password hash
        return $pw->verify($password, $hash);
    }

    /**
     * Validate a user and password using LDAP. This would be commonly used to
     * validate users on a corporate network (for example a Windows Domain).
     *
     * @param string $login
     * @param string $password
     * @return bool
     */
    public function validateLdapUser($login, $password)
    {
        // Use Domain specified as the property or if not set then make a
        // DNS call to get the FQDN (fully-qualified domain name) of the server
        // and attempt to find the domain from the FQDN.
        //
        // IMPORTANT - This is intended only as a working demo for Windows Networks,
        // it's best to set the domain property at the top of this class if using LDAP.
        $domain = $this->domain;
        if ($this->domain === null) {
            $config = new Config();
            $domain = $config->fqdn();
            if (count(explode('.', $domain)) === 3) {
                // Assumes Format: 'server.example.com'
                $domain = substr($domain, strpos($domain, '.') + 1);
            }
        }

        // Use LDAP to verify the user's login and password
        $is_valid = false;
        $resource = ldap_connect($domain);
        if ($resource) {
            try {
                $is_valid = ldap_bind($resource, $login, $password);
            } catch (\Exception $e) {
                $is_valid = false;
            }
            ldap_close($resource);
        }
        return $is_valid;
    }

    /**
     * Load [.env] config file the required key for JWT, CSD, or Encryption
     *
     * @param Application $app
     * @param string $required_key
     */
    private function loadEnv(Application $app, $required_key)
    {
        $file_path = $app->config['APP_DATA'] . '/.env';
        $required_vars = array($required_key);
        DotEnv::loadFile($file_path, $required_vars);
    }

    /**
     * Return [null] or the Authenticated User as an array, example:
     *   [ 'name' => '{user}', 'exp' => timestamp ]
     *
     * @param Application $app
     * @return null|array
     */
    private function getUserFromRequest(Application $app)
    {
        $this->setupDemo($app);

        switch ($this->method) {
            case 'jwt':
                return $this->getUserFromJWT($app);
            case 'csd':
                return $this->getUserFromCSD($app);
            case 'enc':
                return $this->getUserFromCrypto($app);
            case 'ses':
                return $this->getUserFromSession($app);
            default:
                throw new \Exception('Programming Error - Unknown Method');
        }
    }

    /**
     * Return Authenticated User from Authorization Request Header or Cookie
     * using JSON Web Token (JWT).
     *
     * @param Application $app
     * @return array|null
     */
    private function getUserFromJWT(Application $app)
    {
        $this->loadEnv($app, 'JWT_KEY');
        $req = new Request();
        $token = $req->bearerToken();
        if ($token !== null) {
            return Crypto::decodeJWT($token);
        }
        return $req->jwtCookie($this->cookie_name);
    }

    /**
     * Return Authenticated User from Authorization Request Header or Cookie
     * using Crypto Signed Data (CSD).
     *
     * @param Application $app
     * @return array|null
     */
    private function getUserFromCSD(Application $app)
    {
        $this->loadEnv($app, 'SIGNING_KEY');
        $req = new Request();
        $token = $req->bearerToken();
        if ($token !== null) {
            return Crypto::verify($token);
        }
        return $req->verifiedCookie($this->cookie_name);
    }

    /**
     * Return Authenticated User from Authorization Request Header or
     * an Encrypted Cookie.
     *
     * @param Application $app
     * @return array|null
     */
    private function getUserFromCrypto(Application $app)
    {
        $this->loadEnv($app, 'ENCRYPTION_KEY');
        $req = new Request();

        // Decrypt User Object
        $token = $req->bearerToken();
        if ($token !== null) {
            $user = Crypto::decrypt($token);
        } else {
            $user = $req->decryptedCookie($this->cookie_name);
        }

        // Check if User has expired. Encrypted data does not expire (Unlike
        // JWT and Singed Data) so this class handles manually handles the
        // expration time for encrypted data.
        if ($user !== null && time() > $user['exp']) {
            return null;
        }
        return $user;
    }

    /**
     * Return Authenticated User from the PHP Session
     * or null if the user is not set.
     *
     * @param Application $app
     * @return array|null
     */
    private function getUserFromSession()
    {
        $user = null;
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        if (isset($_SESSION['user_name'])) {
            $user = array(
                'name' => $_SESSION['user_name'],
            );
        }
        return $user;
    }

    /**
     * Called when checking user access. This function will update the
     * App Cookie and add the user to [$app->locals].
     *
     * @param Application $app
     * @param array $user
     */
    private function setAppUser(Application $app, array $user)
    {
        // Build a and set a new cookie, this will extend the expiration time
        // based on that last page view. This assumes that the controller
        // sends a reponse using [$app->render()] or creates a response object
        // with cookies from the $app by using [new Response($app)].
        switch ($this->method) {
            case 'jwt':
                $value = Crypto::encodeJWT($user, $this->auth_expires);
                break;
            case 'csd':
                $value = Crypto::sign($user, $this->auth_expires);
                break;
            case 'enc':
                $value = Crypto::encrypt($this->encExp($user));
                break;
            case 'ses':
                // If using PHP Sessions simply set the user to app locals and exit function.
                // PHP will then handle the expiration and cookies.
                $app->locals['user'] = $user;
                return;
            default:
                throw new \Exception('Programming Error - Unknown Method');
        }
        $app->cookie($this->cookie_name, $value, $this->cookie_expires, $this->cookie_path, $this->cookie_domain, $this->cookie_secure, $this->cookie_httponly);

        // For API's and Mobile Apps the Access Token can be read from a Response Header
        $app->header($this->res_auth_header, $value);

        // Update the User 'exp' property with that latest time. Internally this
        // is handled by the encoded value for JWT and CSD and for Encryption it
        // is handled by logic. This is optional and included here so that
        // it can render on the example template.
        $user['exp'] = strtotime($this->auth_expires);

        // Add user to local variables so it can be referenced by app
        // code and used for template rendering from [$app->render()].
        $app->locals['user'] = $user;
    }

    /**
     * Encrypted data does not expire or have a timeout like JWT or Signed Data
     * so a 'exp' property is manually added and verified during decryption.
     *
     * @param array $user
     * @return array
     */
    private function encExp($user)
    {
        $user['exp'] = strtotime($this->auth_expires);
        return $user;
    }

    /**
     * Return a new Response with a Cookie and Response Header using a JSON Web Token (JWT).
     * This function is called by the [login()] method.
     *
     * @param Application $app
     * @param array $user
     * @return Response
     */
    private function loginResponseJWT(Application $app, array $user)
    {
        $this->loadEnv($app, 'JWT_KEY');
        $token = Crypto::encodeJWT($user, $this->auth_expires);
        return $this->loginResponse($app, $token);
    }

    /**
     * Return a new Response with a Cookie and Response Header using Crypto Signed Data (CSD).
     * This function is called by the [login()] method.
     *
     * @param Application $app
     * @param array $user
     * @return Response
     */
    private function loginResponseCSD(Application $app, array $user)
    {
        $this->loadEnv($app, 'SIGNING_KEY');
        $token = Crypto::sign($user, $this->auth_expires);
        return $this->loginResponse($app, $token);
    }

    /**
     * Return a new Response with a Cookie and Response Header using an Encrypted.
     * This function is called by the [login()] method.
     *
     * @param Application $app
     * @param array $user
     * @return Response
     */
    private function loginResponseCrypto(Application $app, array $user)
    {
        $this->loadEnv($app, 'ENCRYPTION_KEY');
        $token = Crypto::encrypt($this->encExp($user));
        return $this->loginResponse($app, $token);
    }

    /**
     * Build and return the login JSON response once the access token
     * has been generated.
     *
     * @param Application $app
     * @param string $token
     * @return Response
     */
    private function loginResponse(Application $app, $token)
    {
        $res = new Response($app);
        $res
            ->cookie($this->cookie_name, $token, $this->cookie_expires, $this->cookie_path, $this->cookie_domain, $this->cookie_secure, $this->cookie_httponly)
            ->header($this->res_auth_header, $token)
            ->json(array('success' => true));
        return $res;

        // The above code sends both a cookie and response header for the token.
        // If only a cookie is needed for a website then helper functions can be
        // used instead the using [Crypto] class directly. Example:
        //
        // $res->jwtCookie($this->cookie_name, $user, $this->auth_expires, $this->cookie_expires, ...)
        // $res->signedCookie($this->cookie_name, $user, $this->auth_expires, $this->cookie_expires, ...)
        // $res->encryptedCookie($this->cookie_name, $user, $this->cookie_expires, ...);
    }

    /**
     * Return a new Response using a PHP Session for the user.
     * The user's name will be saved to the session variable 'user_name'.
     * This function is called by the [login()] method.
     *
     * @param Application $app
     * @param array $user
     * @return Response
     */
    private function loginResponseSession(Application $app, array $user)
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start(array(
                'cookie_lifetime' => strtotime($this->auth_expires),
                'cookie_path' => $this->cookie_path,
                'cookie_domain' => $this->cookie_domain,
                'cookie_secure' => $this->cookie_secure,
                'cookie_httponly' => $this->cookie_httponly,
            ));
        }
        $_SESSION['user_name'] = $user['name'];
        $res = new Response($app);
        return $res->json(array('success' => true));
    }
}
