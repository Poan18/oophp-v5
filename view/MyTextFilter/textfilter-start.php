<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());



?>
<div>
    <h1>Exempel på Textfilter</h1>
    <p>Här kan man testa olika testfilter med hjälp av klassen 'MyTextFilter'.</p>
    <a href="<?= url("textfilter/bbcode") ?>">Bbcode</a> |
    <a href="<?= url("textfilter/clickable") ?>">Clickable</a> |
    <a href="<?= url("textfilter/markdown") ?>">Markdown</a> |
    <a href="<?= url("textfilter/nl2br") ?>">Nl2br</a>
</div>
