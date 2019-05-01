<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

?>
<h1>Dices 100 v2</h1>
<div class="game-container">
    <form class="game-form" method ="POST">
        <?php if (!($winnerName)) : ?>
            <input type="submit" name="doRoll" value="Kasta tärningar">
            <?php if ($rollValid) : ?>
                <input type="submit" name="doSave" value="Spara">
            <?php endif; ?>
        <?php endif; ?>

        <input type="submit" name="doReset" value="Starta om">
    </form>
    <br>
    <?php if ($winnerName) : ?>
        <p><?= $winnerName ?> vann med <?= $winnerPoints ?> poäng! </p>
    <?php endif; ?>

    <?php if ($rollNums && !($winnerName)) : ?>
        <?php if ($rollValid) : ?>
            <p>Tärningarna blev <?= $rollNums ?> </p>
            <br>
            <p>Summan av kastet är <?= $rollSum ?> </p>
            <p>Summan av rundan är <?= $roundScore ?> </p>
        <?php else : ?>
            <p>Tärningarna blev <?= $rollNums ?> </p>
            <br>
            <p>En etta rullandes och rundan går över.</p>
        <?php endif; ?>
    <?php endif; ?>
    <br>
    <?php if (!($winnerName)) : ?>
        <p>Det är nu <?= $whosRound ?> tur. </p>
        <br>
    <?php endif; ?>
    <?php if (strlen($histogram) > 4) : ?>
        <p>Histogram <?= $histogram ?></p>
        <br>
    <?php endif; ?>

    <p>Spelaren har totalt <?= $userTotal ?> poäng</p>
    <p>Datorn har totalt <?= $compTotal ?> poäng</p>

</div>
