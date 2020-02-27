<!DOCTYPE html>
<html lang="<?= $app->lang ?>" dir="<?= ($app->lang === 'ar' ? 'rtl' : 'auto'); ?>">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">

		<?php
		$page_title = (isset($page_title) ? $page_title : null);
		if ($page_title === null && isset($i18n['page_title'])) {
			$page_title = $i18n['page_title'];
		}
		?>
		<title><?= $app->escape($i18n['site_title']) ?> | <?= $app->escape($page_title) ?></title>
		
		<link rel="shortcut icon" href="<?= $app->rootDir() ?>favicon.ico" />
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
		<link href="<?= $app->rootDir() ?>css/site.css" rel="stylesheet" />
	</head>
	<body>
		<header>
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
			<nav class="navbar mobile-nav">
				<span class="site-title"><a href="<?= $app->rootUrl() . $app->lang ?>/">
					<svg width="16px" height="16px" viewBox="0 0 16 16" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
						<g id="Buttons" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
							<g id="home" fill="#2e3d47">
								<rect id="Rectangle" x="2" y="10" width="12" height="6"></rect>
								<polygon id="Triangle" points="8 4 14 10 2 10"></polygon>
								<rect id="Rectangle" transform="translate(11.500000, 4.750000) rotate(45.000000) translate(-11.500000, -4.750000) " x="6" y="4" width="11" height="1.5" rx="0.75"></rect>
								<rect id="Rectangle" transform="translate(4.500000, 4.750000) scale(-1, 1) rotate(45.000000) translate(-4.500000, -4.750000) " x="-1" y="4" width="11" height="1.5" rx="0.75"></rect>
								<polygon id="Rectangle" points="12 0 14 0 14 5 12 3"></polygon>
							</g>
						</g>
					</svg>
				<span style="margin-left:8px;"><?= $app->escape($i18n['site_title']) ?></span>
				</a></span>
				<span class="open-menu"><a href="#">
					<svg width="16px" height="16px" viewBox="0 0 16 16" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
						<g id="Buttons" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
							<g id="open-menu" transform="translate(0.000000, -1.000000)" fill="#2e3d47">
								<rect id="Rectangle" x="0" y="2" width="16" height="3" rx="1.5"></rect>
								<rect id="Rectangle" x="0" y="8" width="16" height="3" rx="1.5"></rect>
								<rect id="Rectangle" x="0" y="14" width="16" height="3" rx="1.5"></rect>
							</g>
						</g>
					</svg>
				</a></span>
                <div class="mobile-menu" style="display:none;">
                    <div>
                        <span class="close-menu"><a href="#">
                            <svg width="16px" height="16px" viewBox="0 0 16 16" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <g id="Buttons" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <g id="close-menu" fill="#4F5B93">
                                        <rect id="Rectangle" transform="translate(7.707107, 8.207107) rotate(45.000000) translate(-7.707107, -8.207107) " x="-2.29289322" y="6.70710678" width="20" height="3" rx="1.5"></rect>
                                        <rect id="Rectangle" transform="translate(8.131728, 8.131728) scale(-1, 1) rotate(45.000000) translate(-8.131728, -8.131728) " x="-1.86827202" y="6.63172798" width="20" height="3" rx="1.5"></rect>
                                    </g>
                                </g>
                            </svg>
                        </a></span>
                    </div>
                    <ul>
						<li class="nav-item <?= (isset($nav_active_link) && $nav_active_link === 'home' ? 'active' : '') ?>">
							<a class="nav-link" href="<?= $app->rootUrl() . $app->lang ?>/"><?= $app->escape($i18n['menu_home']) ?></a>
						</li>
						<li class="nav-item <?= (isset($nav_active_link) && $nav_active_link === 'resources' ? 'active' : '') ?>">
							<a class="nav-link" href="<?= $app->rootUrl() . $app->lang ?>/resources"><?= $app->escape($i18n['menu_resources']) ?></a>
						</li>
						<li class="nav-item <?= (isset($nav_active_link) && $nav_active_link === 'lorem-ipsum' ? 'active' : '') ?>">
							<a class="nav-link" href="<?= $app->rootUrl() . $app->lang ?>/lorem-ipsum"><?= $app->escape($i18n['menu_lorem_ipsum']) ?></a>
						</li>
						<li class="nav-item <?= (isset($nav_active_link) && $nav_active_link === 'auth-demo' ? 'active' : '') ?>">
							<a class="nav-link" href="<?= $app->rootUrl() . $app->lang ?>/auth-demo"><?= $app->escape($i18n['menu_auth_demo']) ?></a>
						</li>
					</ul>
					<ul class="i18n-menu">
						<li<?= ($app->lang === 'en' ? ' class="active"' : '') ?>>
							<a href="<?= $app->escape($app->rootUrl() . 'en' . $current_page) ?>">English</a>
						</li>
						<li<?= ($app->lang === 'es' ? ' class="active"' : '') ?>>
							<a href="<?= $app->escape($app->rootUrl() . 'es' . $current_page) ?>">Español</a>
						</li>
						<li<?= ($app->lang === 'pt-BR' ? ' class="active"' : '') ?>>
							<a href="<?= $app->escape($app->rootUrl() . 'pt-BR' . $current_page) ?>">Português (Brasil)</a>
						</li>
                        <li<?= ($app->lang === 'ar' ? ' class="active"' : '') ?>>
                            <a href="<?= $app->escape($app->rootUrl() . 'ar' . $current_page) ?>">العربية</a>
                        </li>
					</ul>
				</div>
			</nav>
			<nav class="navbar desktop-nav">
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
					<li class="nav-item <?= (isset($nav_active_link) && $nav_active_link === 'auth-demo' ? 'active' : '') ?>">
						<a class="nav-link" href="<?= $app->rootUrl() . $app->lang ?>/auth-demo"><?= $app->escape($i18n['menu_auth_demo']) ?></a>
					</li>
					<li class="nav-item sub-menu i18n-menu">
						<div>
							<svg width="24px" height="24px" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
								<g id="Buttons" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
									<g id="i18n" stroke="#2e3d47">
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
								<a href="<?= $app->escape($app->rootUrl() . 'pt-BR' . $current_page) ?>">Português (Brasil)</a>
							</li>
							<li<?= ($app->lang === 'ar' ? ' class="active"' : '') ?>>
								<a href="<?= $app->escape($app->rootUrl() . 'ar' . $current_page) ?>">العربية</a>
							</li>
						</ul>
					</li>
				</ul>
			</nav>
			<script>
				(function() {
					// Mobile Nav Menu
					var openMenu = document.querySelector('.mobile-nav .open-menu a');
					var closeMenu = document.querySelector('.mobile-nav .close-menu');
					var mobileMenu = document.querySelector('.mobile-menu');
					openMenu.onclick = function(e) { e.preventDefault(); mobileMenu.style.display = ''; };
					closeMenu.onclick = function(e) { e.preventDefault(); mobileMenu.style.display = 'none'; };
				})();
			</script>
		</header>
		<main>
			<section id="old-browser-warning" style="display:none;">
				<div class="alert alert-danger" data-content="<?= $app->escape($i18n['old_browser_warning']) ?>"></div>
			</section>
