<?php

/**
 * File containing class 'Game'
 *
 * @author  Pontus Andersson (Poan18)
 */

namespace Pon\Dices;

/**
 * Class Game.
 */
class Game
{
    /**
     * @var DiceHand  $userHand  Hand of the user.
     * @var DiceHand  $compHand  Hand of the computer.
     * @var GameRound $round     The current round.
     * @var string    $compHand  The current round belong to this player name.
     */
    private $userHand;
    private $compHand;
    private $round;
    private $roundNum;

    /**
     * Constructor to assign hands and round name..
     */
    public function __construct()
    {
        $this->userHand = new DiceHand();
        $this->compHand = new DiceHand();
        $this->roundNum = "Datorns";
    }

    /**
     * Start the round.
     *
     * @return void.
     */
    public function startRound()
    {
        if ($this->roundNum == "Spelarens") {
            $this->round = new GameRound($this->compHand);
            $this->roundNum = "Datorns";
        } else {
            $this->round = new GameRound($this->userHand);
            $this->roundNum = "Spelarens";
        }
    }

    /**
     * Roll the dices.
     *
     * @return array with dice rolls, sum and if boolean if they rolled a 1.
     */
    public function doRoll()
    {
        $rollRes = $this->round->rollRound();

        if ($rollRes[2] == false) {
            $this->startRound();
            return $rollRes;
        }
        return $rollRes;
    }

    /**
     * Score in current round.
     *
     * @return int as the score of the round.
     */
    public function roundScore()
    {
        return $this->round->getRoundScore();
    }

    /**
     * Current round belongs to who.
     *
     * @return string as the name of the player who has the current round.
     */
    public function whosRound()
    {
        return $this->roundNum;
    }

    /**
     * Save current round score.
     *
     * @return void
     */
    public function saveScore()
    {
        if ($this->roundNum == "Spelarens") {
            $roundScore = $this->round->getRoundScore();
            $this->userHand->addSaved($roundScore);
            return;
        }

        $roundScore = $this->round->getRoundScore();
        $this->compHand->addSaved($roundScore);
    }

    /**
     * Return hand score.
     *
     * @return array as player and computer hand scores.
     */
    public function returnScore()
    {
        return array($this->userHand->getSaved(), $this->compHand->getSaved());
    }

    /**
     * Check if someone has won.
     *
     * @return string as the winner.
     */
    public function checkWinner()
    {
        if ($this->userHand->getSaved() >= 100) {
            return "userWin";
        } elseif ($this->compHand->getSaved() >= 100) {
            return "compWin";
        }
    }
}
