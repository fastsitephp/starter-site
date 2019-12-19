# 🌟 FastSitePHP Starter Site

**Thanks for visiting!** 🌠👍

**This is the main Starter Site for FastSitePHP.** It includes several examples pages and provides a basic directory/file structure. The site is designed to provide structure for basic content (JavaScript, CSS, etc) while remaining small in size so that it is easy to remove files you don’t need and customize it for your site.

## 🚀 Getting Started

**Getting started with PHP and FastSitePHP is extremely easy.** If you do not have PHP installed then see instructions for Windows, Mac, and Linux on the getting started page:

<a href="https://www.fastsitephp.com/en/getting-started" target="_blank">https://www.fastsitephp.com/en/getting-started</a>

The starter site does not include the Framework so you will need to run [scripts/install.php] to download it and install it. Once setup you can launch a site from the command-line as show below or if you use a Code Editor or IDE [Visual Studio Code, GitHub Atom, etc] then you can launch the site directly from your editor. See the above getting started page for more.

### Download and run this site

~~~
# Download this Repository
cd {starter-site-root}
php ./scripts/install.php
php -S localhost:3000
~~~

### Create a new project using Composer (PHP Dependency/Package Manager)

In addition to downloading this repository you can also start a new project using Composer.

~~~
composer create-project fastsitephp/starter-site my-app
cd my-app
php -S localhost:3000
~~~

### Install directly on a server

A bash script is available for a quick setup of Apache, PHP, and FastSitePHP with a Starter Site. This script works for a full setup on a default OS when nothing is installed.

Supported Operating Systems (more will be added in the future):

* Ubuntu 18.04 LTS

~~~
wget https://www.fastsitephp.com/downloads/create-fast-site.sh
sudo bash create-fast-site.sh
~~~

## 💻 Starter Site Screenshots (Print Screens)

![Starter Site Home Page](https://raw.githubusercontent.com/fastsitephp/static-files/master/img/starter_site/2019-06-17/home-page.png)

![Starter Site Example Page](https://raw.githubusercontent.com/fastsitephp/static-files/master/img/starter_site/2019-06-17/data-page.png)

## 🤝 Contributing

* If you find a typo or grammar error please fix and submit.
* If you would like to help with translations then please submit JSON language files in [app_data\i18n].
* If you would like to submit any other changes then please open an issue first. This is intended to be a minimal site so adding more code needs a good reason.

## :memo: License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
