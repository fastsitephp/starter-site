<div class="container">
    <h1><?= $app->escape($i18n['page_title']) ?></h1>

    <section class="d-inline-flex">
        <ul class="nav flex-column d-inline-flex text-left">
            <?php foreach ($links as $link): ?>
            <li class="nav-item">
                <a href="<?php echo $app->escape($link['url']) ?>" target="_blank">
                <?php echo $app->escape($link['title']) ?>
                </a>
            </li>
            <?php endforeach ?>
        </ul>
    </section>
</div>