# FastSitePHP Starter Site Change Log

FastSitePHP uses [Semantic Versioning](https://docs.npmjs.com/about-semantic-versioning).

## 1.4.1 (September 2, 2020)

* Minor CSS Updates for Nav Menu
  * Desktop - Padding is consistant on active and regular menu
  * Desktop - Top margin update by several pixels
  * Mobile - Easier editing of CSS for padding

## 1.4.0 (August 7, 2020)

* Added a default `CSP (Content-Security-Policy)` Response Header for HTML Responses
  * By default strict rules are used so that only content from the current domain can be included.
  * A commented example is included to show how to include additional connent.
* Added default Cookie Attribute for Auth Page: `SameSite = Lax`.
  * Requires FastSitePHP Framework `1.4.0` or higher and only works when using PHP 7.3 or Higher.
  * Updated `composer.json` file to require FastSitePHP Framework `1.4.0` or higher
* Updated the Starter Site Bash Install Script to install PHP `7.4` by default instead of `7.2`.
  * The bash script is part of the main FastSitePHP Repository
  * https://github.com/fastsitephp/fastsitephp/blob/master/scripts/shell/bash/create-fast-site.sh
  * Added support for `Ubuntu 20.04 LTS` - tested on [DigitalOcean](https://www.digitalocean.com/)
  * Confirmed that the script works with `Ubuntu 16.04 LTS` for both Apache and nginx
* Moved all inline JavaScript `<script>` elements to seperate JavaScript Files and all CSS inline `style` to style sheets so that the site works with the new strict CSP
* Added various code comments related to security options
* Updated Mobile Nav Menu to use only CSS rather than CSS and JavaScript
* Minor site style updates such as centered text on the mobile nav menu items
* Add support for Auth Example JavaScript Code with IE 11 and Older Browsers
* Added a new `css/layout.css` file and used as a default instead of Bootstrap
  * Bootstrap remains commented out in the `app/Views/_header.php` file
  * The CDN version of Bootstrap is about 160 kB of CSS gzipped to 24 kB.
  * The `layout.css` alternative file is less than 4 kB, however it contains only a very limited amount of CSS needed for the starter site.
  * Updated the commented version of Bootstap from `4.4.1` to `4.5.2`
* Updated Logout Button and Related API to redirect to the user's selected language rather than the default site language
* Added meta description tag option in the `app/Views/_header.php` file
* Updated `scripts/install.php` to download and use latest version of `cacert.pem`.
  * Previous version: `2019-10-16`
  * New version: `2020-06-24`

## 1.3.2 (July 14, 2020)

* Added support for the Mac-only development environment Laravel Valet
  * Related to issue https://github.com/fastsitephp/starter-site/issues/4
  * **Thanks Valentin Ursuleac** https://github.com/ursuleacv for finding and opening this issue!

## 1.3.1 (February 27, 2020)

* Added `Vary` Response Header with `Accept-Language` on the default route
* Improved Layout for Mobile Nav Menu Items
* Fix Mobile Nav Menu to appear on IE 11 for Narrow Layouts

## 1.3.0 (February 27, 2020)

* Added Mobile Menu
* Added Arabic Translations and updated HTML for using RTL Language Support
* Fixed `<html lang>` attribute to use the selected language
* Added Support for PHP `5.3`. Even though the PHP Group no longer supports PHP 5.3 it is installed on many older servers and some widely used versions of Linux still install it by default.

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
