<?php

namespace Pon\Dicesv2;

/**
 * A dice which has the ability to present data to be used for creating
 * a histogram.
 */
class DiceHistogram2 extends Dice implements HistogramInterface
{
    use HistogramTrait2;

    // /**
    //  * Get min value for the histogram.
    //  *
    //  * @return int with the min value.
    //  */
    // public function getHistogramMin()
    // {
    //     return 1;
    // }
    //
    // /**
    //  * Get max value for the histogram.
    //  *
    //  * @return int with the max value.
    //  */
    // public function getHistogramMax()
    // {
    //     return 6;
    // }
}
