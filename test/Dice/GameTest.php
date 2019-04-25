<?php

namespace Pon\Dices;

use PHPUnit\Framework\TestCase;

/**
 * Test class for Game.php
 */
class GameTest extends TestCase
{
    /**
     * Construct game object and check if it has expected properties.
     */
    public function testCreateGame()
    {
        $game = new Game();
        $this->assertInstanceOf("\Pon\Dices\Game", $game);
    }

    /**
     * Check no winner
     */
    public function testCheckNoWinner()
    {
        $game = new Game();
        $this->assertInstanceOf("\Pon\Dices\Game", $game);

        $res = $game->checkWinner();
        $exp = "";
        $this->assertEquals($exp, $res);
    }

    /**
     * Test start a new round.
     */
    public function testStartRound()
    {
        $game = new Game();
        $this->assertInstanceOf("\Pon\Dices\Game", $game);

        $game->startRound();
        $res = $game->whosRound();
        $exp = "Spelarens";
        $this->assertEquals($exp, $res);

        $game->startRound();
        $res = $game->whosRound();
        $exp = "Datorns";
        $this->assertEquals($exp, $res);
    }

    /**
     * Test get round score.
     */
    public function testRoundScore()
    {
        $game = new Game();
        $this->assertInstanceOf("\Pon\Dices\Game", $game);

        $game->startRound();

        $res = $game->roundScore();
        $exp = 0;
        $this->assertEquals($exp, $res);
    }

    /**
     * Test roll all dices from Game object.
     */
    public function testDoRoll()
    {
        $game = new Game();
        $this->assertInstanceOf("\Pon\Dices\Game", $game);

        $game->startRound();

        $res = $game->doRoll();
        $this->assertIsArray($res[0]);
        $this->assertIsInt($res[1]);
        $this->assertInternalType('bool', $res[2]);
    }

    /**
     * Test save score from Game object.
     */
    public function testSaveScore()
    {
        $game = new Game();
        $this->assertInstanceOf("\Pon\Dices\Game", $game);

        $game->startRound();
        $game->saveScore();
        $res = $game->returnScore();
        $exp = 0;
        $this->assertEquals($exp, $res[0]);

        $game->startRound();
        $game->saveScore();
        $exp = 0;
        $this->assertEquals($exp, $res[1]);
    }
}
