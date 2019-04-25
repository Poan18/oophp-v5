<?php
/**
 * Create routes using $app programming style.
 */
//var_dump(array_keys(get_defined_vars()));



/**
 * Init the game and redirect to play the game.
 */
$app->router->get("dices/init", function () use ($app) {
    // init the session for the gamestart.

    $game = new Pon\Dices\Game();

    $_SESSION["game"] = $game;
    $_SESSION["game"]->startRound();

    $_SESSION["rollNums"] = null;
    $_SESSION["rollSum"] = null;
    $_SESSION["rollValid"] = null;

    return $app->response->redirect("dices/play");
});



/**
 * Show game status
 */
$app->router->get("dices/play", function () use ($app) {
    $title = "Tärningsspel 100";

    $game = $_SESSION["game"];

    $checkWin = $_SESSION["game"]->checkWinner();
    if ($checkWin == "userWin") {
        $winnerName = "Spelaren";
        $winnerPoints = $game->returnScore()[0];
    } elseif ($checkWin == "compWin") {
        $winnerName = "Datorn";
        $winnerPoints = $game->returnScore()[1];
    }

    $roundScore = $game->roundScore() ?? null;
    $whosRound = $game->whosRound() ?? null;
    $userTotal = $game->returnScore()[0] ?? null;
    $compTotal = $game->returnScore()[1] ?? null;

    $data = [
        "userTotal" =>  $userTotal ?? null,
        "compTotal" =>  $compTotal ?? null,
        "rollNums" => $_SESSION["rollNums"] ?? null,
        "rollSum" => $_SESSION["rollSum"] ?? null,
        "rollValid" => $_SESSION["rollValid"] ?? null,
        "roundScore" => $roundScore ?? null,
        "whosRound" => $whosRound ?? null,
        "winnerName" => $winnerName ?? null,
        "winnerPoints" => $winnerPoints ?? null
    ];

    $app->page->add("dices/play", $data);

    return $app->page->render([
        "title" => $title,
    ]);
});

/**
 * Choices
 */
$app->router->post("dices/play", function () use ($app) {

    if ($_POST["doRoll"] ?? false) {
        $rollRes = $_SESSION["game"]->doRoll();
        $_SESSION["rollNums"] = implode(", ", $rollRes[0]);
        $_SESSION["rollSum"] = $rollRes[1];
        $_SESSION["rollValid"] = $rollRes[2];
    }

    if ($_POST["doReset"] ?? false) {
        return $app->response->redirect("dices/init");
    }

    if ($_POST["doSave"] ?? false) {
        $_SESSION["game"]->saveScore();
        $_SESSION["game"]->startRound();
        $_SESSION["rollNums"] = null;
        $_SESSION["rollSum"] = null;
        $_SESSION["rollValid"] = null;
    }

    return $app->response->redirect("dices/play");
});
