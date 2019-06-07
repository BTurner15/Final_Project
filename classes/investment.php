<?php


class Investment
{
    private $_cost;
    private $_timeTravel;
    private $_timeVisit;

    /**
     * Location constructor.
     * @param $cost
     * @param $timeTravel
     * @param $timeVisit
     */

    public function __construct($cost, $timeTravel, $timeVisit)
    {
        $this->_cost = $cost;
        $this->_timeTravel = $timeTravel;
        $this->_timeVisit = $timeVisit;
    }

    /**
     * @return integer
     */
    public function getCost()
    {
        return $this->_cost;
    }

    /**
     * @return integer
     */
    public function getTimeTravel()
    {
        return $this->_timeTravel;
    }

    /**
     * @return integer
     */
    public function getTimeVisit()
    {
        return $this->_timeVisit;
    }

    /**
     * @param integer $cost
     */
    public function setCost($cost)
    {
        $this->_cost = $cost;
    }

    /**
     * @param integer $timeTravel, days, both ways
     */
    public function setTimeTravel($timeTravel)
    {
        $this->_timeTravel = $timeTravel;
    }

    /**
     * @param integer $timeVisit, time spent in days, while on-site
     */
    public function setTimeVisit($timeVisit)
    {
        $this->_timeVisit = $timeVisit;
    }
}