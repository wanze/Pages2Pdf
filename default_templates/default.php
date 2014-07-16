<?php
/*
 * Pages2Pdf default template
 *
 * This template is used if you have enabled creating PDF files for a template in the module config
 * but didn't create a corresponding template file in '/site/templates/pages2pdf/ folder.
 *
 * Styles defined in styles.css file
 */
?>

<h1><?= $page->get('headline|title') ?></h1>
<p><?= $page->body ?></p>

<?php if (count($page->images)): ?>
    <?php foreach ($page->images as $image): ?>
        <div class="image">
        <img src="<?= $image->size(400, 400)->url ?>" alt="<?= $image->description ?>" />
        </div>
    <?php endforeach; ?>
<?php endif; ?>