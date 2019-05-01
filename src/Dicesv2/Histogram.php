<?php

namespace Pon\Dicesv2;

/**
 * Generating histogram data.
 */
class Histogram
{
    /**
     * @var array $serie  The numbers stored in sequence.
     * @var int   $min    The lowest possible number.
     * @var int   $max    The highest possible number.
     */
    private $serie = [];
    private $min;
    private $max;


    /**
     * Return a string with a textual representation of the histogram.
     *
     * @return string representing the histogram.
     */
    public function getAsText()
    {
        $histogram = "<br>";
        $min = $this->min;
        $max = $this->max;

        if ($min && $max) {
            $nonum = true;

            while ($min <= $max) {
                $rownum = strval($min) . ": ";
                foreach ($this->serie as $num) {
                    if ($num == $min) {
                        $rownum .= "*";
                        $nonum = false;
                    }
                }
                if ($nonum) {
                    $rownum = "";
                } else {
                    $rownum .= "<br>";
                }
                $histogram .= $rownum;
                $nonum = true;
                $min++;
            }
        }

        return $histogram;
    }



    /**
     * Inject the object to use as base for the histogram data.
     *
     * @param HistogramInterface $object The object holding the serie.
     *
     * @return void.
     */
    public function insertData($values, HistogramInterface $dice)
    {
        $this->serie = array_merge($this->serie, $values);
        $this->min   = $dice->getHistogramMin();
        $this->max   = $dice->getHistogramMax();
    }
}
