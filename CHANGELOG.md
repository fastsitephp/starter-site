# FastSitePHP Starter Site Change Log

FastSitePHP uses [Semantic Versioning](https://docs.npmjs.com/about-semantic-versioning).

## 1.2.0 (January 10, 2020)

* Site - Added Authentication Demo
  * Auth Middleware - Includes options for JWT, Signed Cookies, Encrypted Cookies, PHP Sessions, Database, LDAP / Windows Networks
  * Auth Controller
  * Auth Routing Examples
  * Login Page
* Site - Added i18n nav menu
* Site - Added `Env->loadDotEnv()` middleware function and additional usage docs for the `Env` middleware
* Site - Updated `Bootstap` Version from `4.3.1` to `4.4.1`
* Scripts - Added Bash Template Script for Syncing Site updates: `starter-site\scripts\sync-server.sh`
* Documentation - Added Directory Structure to the main readme file
* Documentation - Added `es` and `pt-BR` translations for the readme file

## 1.1.2 (December 16, 2019)

* Brazilian Portuguese [pt-BR] language tranlations added
  * **Thanks Marcelo dos Santos Mafra!** https://github.com/msmafra
* Updated [install.php] to use to use the most recent release of FastSitePHP and to provide an exit error code if the script files.

## 1.1.1 (December 11, 2019)

* Update [install.php] to use to handle composer directory structure for FastSitePHP so it doesn't attempt to install over composer. This would have caused an error on the install script if running after previously setting up the site with composer; however it didn't cause any site errors.

## 1.1.0 (December 10, 2019)

* Update [install.php] to use FastSitePHP Framework 1.1.0
* Updated Site so that the Root URL redirects to the user's default language based the 'Accept-Language' request header and available languages.

## 1.0.1 (November 22, 2019)

* CSS Update for &lt;table&gt; background color
* Fixed links on Resources page
* Documentation updates

## 1.0.0 (November 14, 2019)

* Initial public release
