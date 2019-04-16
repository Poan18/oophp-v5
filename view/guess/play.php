<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());



?>
<div class="game-container">
    <h1 class="title">I challenge you to <i>Guess my number.</i></h2>
    <form method="POST" class="game-form">
        <input type="number" name="guess" required>

        <?php if ($res != "correct, you won!" && $tries > 0) : ?>
            <input class="doGuess" type="submit" name="doGuess" value="Make a guess">
            <br>
            <br>
            <input type="submit" name="doCheat" value="Cheat" formnovalidate>
        <?php else : ?>
            <br><br>
        <?php endif; ?>
        <input type="submit" name="doRestart" value="Restart" formnovalidate>
    </form>

    <h2>Tries left: <?= $tries ?></h2>

    <?php if ($res ?? false) : ?>
        <p class="<?= $res ?>">Your guess is <?= $res ?></p>
    <?php endif; ?>

    <?php if ($cheat ?? false) : ?>
        <h1><?= $num ?></h1>
    <?php endif; ?>

    <?php if ($res != "correct, you won!" && $tries == 0) : ?>
        <p>Game over. The number was <strong><?= $num ?></strong>.</p>
        <p>Press 'restart' to start a new game.</p>
    <?php endif; ?>
</div>
