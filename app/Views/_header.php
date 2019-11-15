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
				</ul>
			</nav>
		</header>
		<main>
			<section id="old-browser-warning" style="display:none;">
				<div class="alert alert-danger" data-content="<?= $app->escape($i18n['old_browser_warning']) ?>"></div>
			</section>
