<?php

namespace Pon\Dicesv2;

/**
 * A trait implementing HistogramInterface.
 */
trait HistogramTrait2
{

    /**
     * Get min value for the histogram.
     *
     * @return int with the min value.
     */
    public function getHistogramMin()
    {
        return 1;
    }



    /**
     * Get max value for the histogram.
     *
     * @return int with the max value.
     */
    public function getHistogramMax()
    {
        return 6;
    }
}
