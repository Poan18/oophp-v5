<?php

/**
 * File containing class 'Guess'
 *
 * @author  Pontus Andersson (Poan18)
 */

 namespace Pon\Guess;

/**
 * Guess my number, a class supporting the game through GET, POST and SESSION.
 */
class Guess
{
    /**
     * @var int $number   The current secret number.
     */
    private $number;

    /**
     * @var int $tries    Number of tries a guess has been made.
     */
    private $tries;


    /**
     * Constructor to initiate the object with current game settings,
     * if available. Randomize the current number if no value is sent in.
     *
     * @param int $number The current secret number, default -1 to initiate
     *                    the number from start.
     * @param int $tries  Number of tries a guess has been made,
     *                    default 6.
     */
    public function __construct(int $number = -1, int $tries = 6)
    {
        $this->tries = $tries;
        $this->number = $number;
        if ($number == -1) {
            $this->random();
        }
    }



    /**
     * Randomize the secret number between 1 and 100 to initiate a new game.
     *
     * @return void
     */
    public function random()
    {
        $this->number = rand(1, 100);
    }




    /**
     * Get number of tries left.
     *
     * @return int as number of tries made.
     */
    public function tries()
    {
        return $this->tries;
    }



    /**
     * Get the secret number.
     *
     * @return int as the secret number.
     */
    public function number()
    {
        return $this->number;
    }



    /**
     * Make a guess, decrease remaining guesses and return a string stating
     * if the guess was correct, too low or to high or if no guesses remains.
     *
     * @throws GuessException when guessed number is out of bounds.
     *
     * @param int $number The guessed number.
     *
     * @return string to show the status of the guess made.
     */
    public function makeGuess($number)
    {
        $this->tries -= 1;

        if ($number <= 0 || $number > 100) {
            throw new GuessException("The guessed number is out of bounds..");
        } else if ($number == $this->number) {
            return "correct, you won!";
        } else if ($number > $this->number) {
            return "too high.";
        } else if ($number < $this->number) {
            return "too low.";
        } else {
            return "... What kind of guess is that?";
        }
    }
}
