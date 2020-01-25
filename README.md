# 🌟 FastSitePHP Starter Site

**Thanks for visiting!** 🌠👍

<table>
	<tbody>
		<tr align="center"><td colspan="2">
<g-emoji class="g-emoji" alias="globe_with_meridians" fallback-src="https://github.githubassets.com/images/icons/emoji/unicode/1f310.png"><img class="emoji" alt="globe_with_meridians" height="20" width="20" src="https://github.githubassets.com/images/icons/emoji/unicode/1f310.png"></g-emoji> <g-emoji class="g-emoji" alias="earth_americas" fallback-src="https://github.githubassets.com/images/icons/emoji/unicode/1f30e.png"><img class="emoji" alt="earth_americas" height="20" width="20" src="https://github.githubassets.com/images/icons/emoji/unicode/1f30e.png"></g-emoji> <g-emoji class="g-emoji" alias="earth_asia" fallback-src="https://github.githubassets.com/images/icons/emoji/unicode/1f30f.png"><img class="emoji" alt="earth_asia" height="20" width="20" src="https://github.githubassets.com/images/icons/emoji/unicode/1f30f.png"></g-emoji> <g-emoji class="g-emoji" alias="earth_africa" fallback-src="https://github.githubassets.com/images/icons/emoji/unicode/1f30d.png"><img class="emoji" alt="earth_africa" height="20" width="20" src="https://github.githubassets.com/images/icons/emoji/unicode/1f30d.png"></g-emoji>
		</td></tr>
		<tr>
			<td><a href="https://github.com/fastsitephp/starter-site/blob/master/docs/README.es.md">Español</a>
			</td>
			<td><a href="https://github.com/fastsitephp/starter-site/blob/master/docs/README.es.md">Sitio de inicio de FastSitePHP</a></td>
		</tr>
		<tr>
			<td><a href="https://github.com/fastsitephp/starter-site/blob/master/docs/README.pt-BR.md">Português (do Brasil)</a>
			</td>
			<td><a href="https://github.com/fastsitephp/starter-site/blob/master/docs/README.pt-BR.md">FastSitePHP Starter Site</a></td>
		</tr>
	</tbody>
</table>

**This is the main Starter Site for FastSitePHP.** It includes several examples pages and provides a basic directory/file structure. The site is designed to provide structure for basic content (JavaScript, CSS, etc) while remaining small in size so that it is easy to remove files you don’t need and customize it for your site.

## :rocket: Getting Started

**Getting started with PHP and FastSitePHP is extremely easy.** If you do not have PHP installed then see instructions for Windows, Mac, and Linux on the getting started page:

https://www.fastsitephp.com/en/getting-started

The starter site does not include the Framework so you will need to run `scripts/install.php` to download it and install it. Once setup you can launch a site from the command-line as show below or if you use a Code Editor or IDE [Visual Studio Code, GitHub Atom, etc] then you can launch the site directly from your editor. See the above getting started page for more.

### Download and run this site

~~~text
# Download this Repository
cd {starter-site-root}
php ./scripts/install.php
php -S localhost:3000
~~~

### Create a new project using Composer (PHP Dependency/Package Manager)

In addition to downloading this repository you can also start a new project using Composer.

~~~text
composer create-project fastsitephp/starter-site my-app
cd my-app
php -S localhost:3000
~~~

### Install directly on a server

A bash script is available for a quick setup of a Web Server (Apache or nginx), PHP, and FastSitePHP with a Starter Site. This script works for a full setup on a default OS when nothing is installed.

Supported Operating Systems (more will be added in the future):

* Ubuntu 18.04 LTS

~~~bash
wget https://www.fastsitephp.com/downloads/create-fast-site.sh
sudo bash create-fast-site.sh
~~~

### Supported Versions of PHP

* The FastSitePHP Starter Site works with all versions of PHP from `5.3` to `7.4`.
* If you need to install the Starter Site on a Server with PHP 5.3 you will need to set the `short_open_tag = On` on your server's `php.ini` file.

### Directory Structure

```text
{root}
|
|   # PHP Code
├── app
|   ├── Controllers/*.php
|   ├── Middleware/*.php
|   ├── Models/*.php
|   ├── Views/*.php
│   └── app.php       # Main Application File
│
|   # Application Data Files
├── app_data
│   └── i18n/*.json   # JSON Files for Multiple languages
│
|   # Documentation
├── docs
│
|   # Web Root Folder
├── public
|   ├── css/*
|   ├── img/*
|   ├── js/*
│   └── index.php  # Entry point for web root
│
|   # Application Scripts
├── scripts
│
|   # Vendor files (created when installing dependencies)
└── vendor
```

## :desktop_computer: Starter Site Print Screens (Screenshots)

![Starter Site Home Page](https://raw.githubusercontent.com/fastsitephp/static-files/master/img/starter_site/2020-01-10/home-page.png)

![Starter Site Example Page](https://raw.githubusercontent.com/fastsitephp/static-files/master/img/starter_site/2020-01-10/data-page.png)

![Starter Site Login Page](https://raw.githubusercontent.com/fastsitephp/static-files/master/img/starter_site/2020-01-10/login-page.png)

## :handshake: Contributing

* If you find a typo or grammar error please fix and submit.
* If you would like to help with translations then please submit the JSON language files in `app_data/i18n`.
* If you would like to submit any other changes then please open an issue first. This is intended to be a minimal site so adding more code needs a good reason.

## :memo: License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
