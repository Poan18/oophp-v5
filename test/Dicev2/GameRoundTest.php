<?php

namespace Pon\Dicesv2;

use PHPUnit\Framework\TestCase;

/**
 * Test class for GameRound.php
 */
class GameRoundTest extends TestCase
{
    /**
     * Construct GameRound object and check if it has expected properties.
     */
    public function testGameRound()
    {
        $diceHand = new DiceHand();
        $gameRound = new GameRound($diceHand);
        $this->assertInstanceOf("\Pon\Dicesv2\GameRound", $gameRound);

        $res = $gameRound->getRoundScore();
        $exp = 0;
        $this->assertEquals($exp, $res);
    }

    /**
     * Test rolling the dices for a round.
     */
    public function testRollRound()
    {
        $diceHand = new DiceHand();
        $gameRound = new GameRound($diceHand);
        $this->assertInstanceOf("\Pon\Dicesv2\GameRound", $gameRound);

        $res = $gameRound->rollRound();
        $this->assertIsArray($res[0]);
        $this->assertIsInt($res[1]);
        $this->assertInternalType('bool', $res[2]);
    }

    /**
     * Test save score to hand.
     */
    public function testSaveHand()
    {
        $diceHand = new DiceHand();
        $gameRound = new GameRound($diceHand);
        $this->assertInstanceOf("\Pon\Dicesv2\GameRound", $gameRound);

        $gameRound->saveHand();
    }
}
