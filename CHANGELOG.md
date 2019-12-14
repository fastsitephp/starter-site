# FastSitePHP Starter Site Change Log

FastSitePHP uses [Semantic Versioning](https://docs.npmjs.com/about-semantic-versioning).

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
