<div class="container">
    <section class="auth-demo">
        <h1><?= $app->escape($i18n['page_title']) ?></h1>
        <p><?= $app->escape($i18n['logged_in_as']) ?> <strong><?= $app->escape($user['name']) ?></strong></p>
        <?php if ($expires !== null): ?>
            <p><?= $app->escape($i18n['expires_at']) ?> <strong><?= $app->escape($expires) ?></strong></p>
            <p><?= $app->escape($i18n['timezone']) ?> <strong><?= $app->escape($timezone) ?></strong></p>
        <?php endif ?>
        <p><a class="btn btn-primary" href="<?= $app->rootUrl() . 'auth/logout' ?>/"><?= $app->escape($i18n['logout']) ?></a></p>
    </section>
</div>
<script src="<?= $app->rootDir() ?>js/auth-demo.js"></script>
