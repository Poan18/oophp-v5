<?php

/**
 * File containing class 'Dice'
 *
 * @author  Pontus Andersson (Poan18)
 */

namespace Pon\Dices;

/**
 * Class Dice.
 */
class Dice
{
    /**
     * @var integer $side  The side of the dice.
     * @var integer $sides Number of sides on the dice.
     */
    private $side;
    private $sides;

    /**
     * Constructor to instantly roll a Dice.
     */
    public function __construct(int $numSides = 6)
    {
        $this->sides = $numSides;
        $this->side = mt_rand(1, 6);
    }

    /**
     * Roll the dice.
     *
     * @return int as the side of the dice.
     */
    public function rollDice()
    {
        $this->side = mt_rand(1, $this->sides);
        return $this->side;
    }

    /**
     * Get the side of the dice.
     *
     * @return int as the side of the dice.
     */
    public function getSide()
    {
        return $this->side;
    }
}
