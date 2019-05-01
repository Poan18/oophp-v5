<?php

namespace Pon\Dicesv2;

use PHPUnit\Framework\TestCase;

/**
 * Test class for Dice.php
 */
class DiceTest extends TestCase
{
    /**
     * Construct Dice object and check if it has expected properties.
     */
    public function testRollDice()
    {
        $dice = new Dice();
        $this->assertInstanceOf("\Pon\Dicesv2\Dice", $dice);

        $res = $dice->rollDice();
        $this->assertIsInt($res);
    }

    /**
     * Test get side method.
     */
    public function testGetSide()
    {
        $dice = new Dice();
        $this->assertInstanceOf("\Pon\Dicesv2\Dice", $dice);

        $res = $dice->getSide();
        $this->assertIsInt($res);
    }
}
