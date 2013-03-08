<?php
/*
 * Pages2Pdf default template
 * This template is used if you have enabled creating pdfs for a template 
 * but didn't create a template file in '/site/templates/pages2pdf/ folder.
 *
 */
?>

<h1><?= $page->get('headline|title') ?></h1>
<p><?= $page->body ?></p>

<?php
//Does the page have some images? Print them. 
//If you have lots of images then wrapping them in a table is the better solution than separating with &nbsp;
if (count($page->images)) {
	foreach ($page->images as $image) {
		$thumb = $image->size(180, 120);
		echo "<img src=\"{$thumb->url}\" width=\"{$thumb->width}\" height=\"{$thumb->height}\" />&nbsp;";
	}
}
?>
