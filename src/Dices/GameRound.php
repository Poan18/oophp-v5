<?php

/**
 * File containing class 'GameRound'
 *
 * @author  Pontus Andersson (Poan18)
 */

namespace Pon\Dices;

/**
 * Class GameRound.
 */
class GameRound
{
    /**
     * @var int $roundScore  Score within the current round.
     * @var DiceHand  $playerHand  Current round belongs to this player.
     */
    private $roundScore;
    private $playerHand;

    /**
     * Assign the round to a DiceHand.
     */
    public function __construct($hand)
    {
        $this->playerHand = $hand;
        $this->roundScore = 0;
    }

    /**
     * Roll all dices.
     *
     * @return array with dice rolls, sum and if boolean if they rolled a 1.
     */
    public function rollRound()
    {
        $this->playerHand->rollHand();
        $res = $this->playerHand->getValues();
        $noRollOne = true;

        foreach ($res as $value) {
            if ($value == 1) {
                $noRollOne = false;
            }
        }
        $sum = $this->playerHand->getSum();
        $this->roundScore += $sum;
        return array($res, $sum, $noRollOne);
    }

    /**
     * Get current round score
     *
     * @return int as the current round score.
     */
    public function getRoundScore()
    {
        return $this->roundScore;
    }

    /**
     * Save current round score to hand.
     *
     * @return void.
     */
    public function saveHand()
    {
        $this->playerHand->addSaved($this->roundScore);
    }
}
