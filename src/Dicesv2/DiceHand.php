<?php

/**
 * File containing class 'DiceHand'
 *
 * @author  Pontus Andersson (Poan18)
 */

namespace Pon\Dicesv2;

/**
 * Class DiceHand.
 */
class DiceHand
{
    /**
     * @var array $dices  Array consisting of dices.
     * @var int  $sides  Array consisting of last roll of the dices.
     * @var int  $saved  Total amount of points.
     */
    private $dices;
    private $sides;
    private $saved;

    /**
     * Constructor to initiate the dicehand with a number of dices.
     *
     * @param int $dices Number of dices to create, defaults to five.
     */
    public function __construct(int $amountDices = 3)
    {
        $this->dices = [];
        $this->sides = [];
        $this->saved = 0;
        for ($i = 0; $i<$amountDices; $i++) {
            array_push($this->dices, new DiceHistogram2());
        }
    }

    /**
     * Roll all dices save their value.
     *
     * @return void.
     */
    public function rollHand()
    {
        $this->sides = [];
        foreach ($this->dices as $dice) {
            $dice->rollDice();
            array_push($this->sides, $dice->getSide());
        }
    }

    /**
     * Get values of dices from last roll.
     *
     * @return array with values of the last roll.
     */
    public function getValues()
    {
        return $this->sides;
    }

    /**
     * Get the sum of all dices.
     *
     * @return int as the sum of all dices.
     */
    public function getSum()
    {
        return array_sum($this->sides);
    }

    /**
     * Get values of dices from last roll.
     *
     * @return int as the saved points..
     */
    public function addSaved($roundPoints)
    {
        $this->saved += $roundPoints;
    }

    /**
     * Get values of dices from last roll.
     *
     * @return int as the saved points..
     */
    public function getSaved()
    {
        return $this->saved;
    }

    /**
     * Get all dices.
     *
     * @return array as the saved dices..
     */
    public function getDices()
    {
        return $this->dices;
    }
}
