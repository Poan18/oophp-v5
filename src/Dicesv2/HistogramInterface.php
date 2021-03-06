<?php

namespace Pon\Dicesv2;

/**
 * A interface for a classes supporting histogram reports.
 */
interface HistogramInterface
{

    /**
     * Get min value for the histogram.
     *
     * @return int with the min value.
     */
    public function getHistogramMin();



    /**
     * Get max value for the histogram.
     *
     * @return int with the max value.
     */
    public function getHistogramMax();
}
