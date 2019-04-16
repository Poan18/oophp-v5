<?php
/**
 * Create routes using $app programming style.
 */
//var_dump(array_keys(get_defined_vars()));



/**
 * Init the game and redirect to play the game.
 */
$app->router->get("guess/init", function () use ($app) {
    // init the session for the gamestart.

    $game = new Pon\Guess\Guess();

    $_SESSION["game"] = $game;
    $_SESSION["res"] = false;

    return $app->response->redirect("guess/play");
});



/**
 * Show game status
 */
$app->router->get("guess/play", function () use ($app) {
    $title = "Play the game!";

    if (!isset($_SESSION["game"])) {
        $_SESSION["game"] = new Pon\Guess\Guess();
        $_SESSION["res"] = false;
    }

    $game = $_SESSION["game"];

    $res = $_SESSION["res"] ?? null;
    $num = $game->number() ?? null;
    $tries = $game->tries() ?? null;
    $cheat = $_SESSION["cheat"] ?? null;

    $data = [
        "res" => $res ?? null,
        "tries" => $tries ?? null,
        "res" => $res ?? null,
        "cheat" => $cheat ?? null,
        "num" => $num ?? null
    ];

    $app->page->add("guess/play", $data);
    $app->page->add("guess/debug");

    return $app->page->render([
        "title" => $title,
    ]);
});

/**
 * Make a guess
 */
$app->router->post("guess/play", function () use ($app) {
    $_SESSION["res"] = false;
    $_SESSION["cheat"] = false;

    if ($_POST["doGuess"] ?? false) {
        $guessObject = $_SESSION["game"];
        $_SESSION["res"] = $guessObject->makeGuess($_POST["guess"]);
        $_SESSION["game"] = $guessObject;
    } else if ($_POST["doRestart"] ?? false) {
        unset($_SESSION["game"]);
    } else if ($_POST["doCheat"] ?? false) {
        $_SESSION["cheat"] = true;
    }

    return $app->response->redirect("guess/play");
});
