<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">

		<title><?= $app->escape($i18n['site_title']) ?> | <?= (isset($page_title) ? $app->escape($page_title) : $app->escape($i18n['page_title'])) ?></title>
		
		<link rel="shortcut icon" href="<?= $app->rootDir() ?>favicon.ico" />
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<link href="<?= $app->rootDir() ?>css/site.css" rel="stylesheet" />
	</head>
	<body>
		<header>
			<nav class="navbar">
				<?php
					// Determine current page for i18n menu links
					$current_page = $app->requestedPath();
					if ($current_page !== '') {
						$components = explode('/', $current_page);
						$current_page = substr($current_page, strlen($components[1]) + 1);
					}
					if ($current_page === '') {
						$current_page = '/';
					}
				?>
				<ul class="navbar-nav flex-row">
					<li class="nav-item <?= (isset($nav_active_link) && $nav_active_link === 'home' ? 'active' : '') ?>">
						<a class="nav-link" href="<?= $app->rootUrl() . $app->lang ?>/"><?= $app->escape($i18n['menu_home']) ?></a>
					</li>
					<li class="nav-item <?= (isset($nav_active_link) && $nav_active_link === 'resources' ? 'active' : '') ?>">
						<a class="nav-link" href="<?= $app->rootUrl() . $app->lang ?>/resources"><?= $app->escape($i18n['menu_resources']) ?></a>
					</li>
					<li class="nav-item <?= (isset($nav_active_link) && $nav_active_link === 'lorem-ipsum' ? 'active' : '') ?>">
						<a class="nav-link" href="<?= $app->rootUrl() . $app->lang ?>/lorem-ipsum"><?= $app->escape($i18n['menu_lorem_ipsum']) ?></a>
					</li>
					<li class="nav-item sub-menu i18n-menu">
						<div>
							<svg width="24px" height="24px" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
								<g id="Buttons" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
									<g id="i18n" stroke="#4F5B93">
										<circle id="Oval" fill="#FFFFFF" cx="12" cy="12" r="11.5"></circle>
										<path d="M12.5,-2.5 C11.8333333,-0.472541163 11.5,2.52745884 11.5,6.5 C11.5,12.4588117 12.5,15.5 12.5,15.5" id="Line" stroke-linecap="square" transform="translate(12.000000, 6.500000) rotate(-90.000000) translate(-12.000000, -6.500000) "></path>
										<ellipse id="Oval" cx="12" cy="12" rx="5.5" ry="11.5"></ellipse>
										<line x1="12" y1="0" x2="12" y2="24" id="Line-2" stroke-linecap="square"></line>
										<path d="M12.5,1 C11.8333333,4.83333333 11.5,8.66666667 11.5,12.5 C11.5,16.3333333 11.8333333,20.1666667 12.5,24" id="Line-2" stroke-linecap="square" transform="translate(12.000000, 12.500000) rotate(-90.000000) translate(-12.000000, -12.500000) "></path>
										<path d="M12.5,8.5 C11.8333333,11.6666667 11.5,14.8333333 11.5,18 C11.5,21.1666667 11.8333333,24.3333333 12.5,27.5" id="Line" stroke-linecap="square" transform="translate(12.000000, 18.000000) rotate(-90.000000) translate(-12.000000, -18.000000) "></path>
									</g>
								</g>
							</svg>
							<span><?= $app->escape($app->lang) ?></span>
						</div>
						<ul>
							<li<?= ($app->lang === 'en' ? ' class="active"' : '') ?>>
								<a href="<?= $app->escape($app->rootUrl() . 'en' . $current_page) ?>">English</a>
							</li>
							<li<?= ($app->lang === 'es' ? ' class="active"' : '') ?>>
								<a href="<?= $app->escape($app->rootUrl() . 'es' . $current_page) ?>">Español</a>
							</li>
							<li<?= ($app->lang === 'pt-BR' ? ' class="active"' : '') ?>>
								<a href="<?= $app->escape($app->rootUrl() . 'pt-BR' . $current_page) ?>">Português (do Brasil)</a>
							</li>
						</ul>
					</li>
				</ul>
			</nav>
		</header>
		<main>
			<section id="old-browser-warning" style="display:none;">
				<div class="alert alert-danger" data-content="<?= $app->escape($i18n['old_browser_warning']) ?>"></div>
			</section>
