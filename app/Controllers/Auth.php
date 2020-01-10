<?php
namespace App\Controllers;

/**
 * The Auth Controller class simply extends Auth Middleware so that functions
 * [login(), logout(), etc.] can be easily used when defining routes.
 */
class Auth extends \App\Middleware\Auth { }
