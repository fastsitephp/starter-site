<div class="container">
    <h1><?= $app->escape($i18n['page_title']) ?></h1>

    <section>
        <button type="button" id="btn-refresh" class="btn btn-primary"><?= $app->escape($i18n['refresh']) ?></button>
        <table class="table table-striped text-left mx-auto mb-0">
            <thead>
                <tr>
                    <th><?= $app->escape($i18n['text1']) ?></th>
                    <th><?= $app->escape($i18n['text2']) ?></th>
                    <th><?= $app->escape($i18n['value']) ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($records as $record): ?>
                <tr>
                    <td><?php echo $app->escape($record['text1']) ?></td>
                    <td><?php echo $app->escape($record['text2']) ?></td>
                    <td><?php echo $app->escape($record['value']) ?></td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </section>
</div>

<script type="module" src="<?= $app->rootDir() ?>js/lorem-ipsum-demo.js"></script>
<script nomodule src="<?= $app->rootDir() ?>js/safari-nomodule.js"></script>
<script nomodule src="<?= $app->rootDir() ?>js/old-browser-warning.js"></script>
