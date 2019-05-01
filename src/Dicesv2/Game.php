<?php

/**
 * File containing class 'Game'
 *
 * @author  Pontus Andersson (Poan18)
 */

namespace Pon\Dicesv2;

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
    private $previousRolls;

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
        $this->previousRolls = $rollRes[0];
        $histogram = $this->returnHistogram();

        if ($rollRes[2] == false) {
            $this->startRound();
            return array($rollRes[1], $rollRes[2], $histogram);
        }

        if ($this->roundNum == "Datorns") {
            $score = $this->round->getRoundScore();
            $saved = $this->compHand->getSaved();

            if ($score + $saved >= 100) {
                $this->saveScore();
                $this->startRound();
                return array($rollRes[1], $rollRes[2], $histogram);
            }

            while ($score <= 20) {
                $rollRes = $this->round->rollRound();
                $this->previousRolls = $rollRes[0];
                $histogram = $this->returnHistogram();
                if ($rollRes[2] == false) {
                    $this->startRound();
                    return array($rollRes[1], $rollRes[2], $histogram);
                }
                $score = $this->round->getRoundScore();
            }
            $this->saveScore();
            $this->startRound();
            return array($rollRes[1], false, $histogram);
        }

        return array($rollRes[1], $rollRes[2], $histogram);
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
            $this->previousRolls = [];
            $roundScore = $this->round->getRoundScore();
            $this->userHand->addSaved($roundScore);
            return;
        }
        $this->previousRolls = [];
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

    /**
     * Create a histogram.
     *
     * @return string as the Histogram chart.
     */
    public function returnHistogram()
    {
        return $this->round->returnHistogram($this->previousRolls);
    }

    /**
     * Return previous rolls.
     *
     * @return array as previous rolls..
     */
    public function getPreviousRolls()
    {

        return $this->previousRolls;
    }
}
