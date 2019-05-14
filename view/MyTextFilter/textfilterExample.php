<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());



?>
<h1><?= $filterName ?></h1>
<a href="<?= url("textfilter") ?>">Översikt</a> |
<a href="<?= url("textfilter/bbcode") ?>">Bbcode</a> |
<a href="<?= url("textfilter/clickable") ?>">Clickable</a> |
<a href="<?= url("textfilter/markdown") ?>">Markdown</a> |
<a href="<?= url("textfilter/nl2br") ?>">Nl2br</a>

<h2>Text innan filtrering</h2>
<pre><?= wordwrap(htmlentities($text)) ?></pre>

<h2>Text efter filtrering</h2>
<?= $html ?>
