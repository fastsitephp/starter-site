<!--
    This is a template login page and is designed to work well with both
    regular Websites and Single Page Apps (SPA).

    Login and Password are sent from a JSON service and if validated a Cookie
    will be sent with the response and the page will be reloaded. This method
    allows for the site to handle the user’s requested URL without having to
    handle redirects.

    JavaScript linked with this page is designed to work with all browswers
    and is small in size so it's easy to customize for your site.
-->
<div class="container">
    <section class="login-form">
        <h1><?= $app->escape($i18n['page_title']) ?></h1>
        <form method="post" action="../<?= $app->escape($app->lang) ?>/auth/login">
            <div class="form-group">
                <input
                    type="text"
                    id="user"
                    name="user"
                    class="form-control"
                    required
                    placeholder="<?= $app->escape($i18n['enter_login']) ?>"
                    autocomplete="username">
                <p><i>Admin</i></p>
            </div>
            <div class="form-group">
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="form-control"
                    required
                    placeholder="<?= $app->escape($i18n['enter_password']) ?>"
                    autocomplete="current-password">
                <p><i>Password123</i></p>
            </div>
            <button type="submit" class="btn btn-primary" id="btn-submit"><?= $app->escape($i18n['submit']) ?></button>
            <div
                class="col mt-4 alert alert-danger"
                role="alert"
                id="error-text"
                style="display:none;"
                data-default-error="<?= $app->escape($i18n['unexpected_error']) ?>">
            </div>
        </form>
    </section>
</div>
<script src="<?= $app->rootDir() ?>js/login-page.js"></script>
