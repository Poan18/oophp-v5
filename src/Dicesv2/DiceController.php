<?php

namespace Pon\Dicesv2;

use Anax\Commons\AppInjectableInterface;
use Anax\Commons\AppInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 * The controller will be injected with $app if implementing the interface
 * AppInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class DiceController implements AppInjectableInterface
{
    use AppInjectableTrait;


    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function initAction() : object
    {
        // init the session for the gamestart.
        $session = $this->app->session;

        $game = new Game();

        $session->set("game", $game);
        $session->get("game")->startRound();

        $session->set("rollNums", null);
        $session->set("rollSum", null);
        $session->set("rollValid", null);
        $session->set("histogram", null);

        return $this->app->response->redirect("dices_v2/play");
    }


    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function playActionGet() : object
    {
        $session = $this->app->session;
        $title = "Tärningsspel 100";

        $game = $session->get("game");
        $checkWin = $session->get("game")->checkWinner();

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
            "rollNums" => $session->get("rollNums"),
            "rollSum" => $session->get("rollSum"),
            "rollValid" => $session->get("rollValid"),
            "roundScore" => $roundScore ?? null,
            "whosRound" => $whosRound ?? null,
            "winnerName" => $winnerName ?? null,
            "winnerPoints" => $winnerPoints ?? null,
            "histogram" => $session->get("histogram")
        ];

        $this->app->page->add("dices_v2/play", $data);

        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function playActionPost() : object
    {
        $session = $this->app->session;
        $request = $this->app->request;
        $game = $session->get("game");

        if ($request->getPost("doRoll")) {
            $rollRes = $session->get("game")->doRoll();
            $session->set("rollNums", implode(", ", $game->getPreviousRolls()));
            $session->set("rollSum", $rollRes[0]);
            $session->set("rollValid", $rollRes[1]);
            $session->set("histogram", $rollRes[2]);
        }

        if ($request->getPost("doReset")) {
            return $this->app->response->redirect("dices_v2/init");
        }

        if ($request->getPost("doSave")) {
            $session->get("game")->saveScore();
            $session->get("game")->startRound();
            $session->set("rollNums", null);
            $session->set("rollSum", null);
            $session->set("rollValid", null);
        }


        return $this->app->response->redirect("dices_v2/play");
    }
}
