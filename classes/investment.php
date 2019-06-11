<?php
/**
 * Bruce Turner, Professor Ostrander, Spring 2019
 * IT 328 Full Stack Web Development
 * Bucket app handling the "milestones" in the DB:
 * file: investment.php
 * date: Thursday, June 6 2019
 * class Investment
 *
 * Conform to the required PEAR coding standards from the git go
 * " Apply PEAR Standards to your class files, including a class-level docblock
 *   above each class, and a docblock above each function. "
 *
 * indent 4 spaces
 * line length max 80 characters
 * class names begin with a upper case
 * private members (variables & functions) are preceded with an underscore
 * constants are all Uppercase
 * add PHPDoc to each class & function
 */
//3456789_123456789_123456789_123456789_123456789_123456789_123456789_1234567890
// the above is 80 characters
// Provide the database connection with the required database credentials
// stored as constants outside of public_html

class Investment
{
    private $_cost;
    private $_timeTravel;
    private $_timeVisit;

    /**
     * Location constructor.
     * @param $cost         //integer, measured in US dollars
     * @param $timeTravel   // integer, measured in travel to/from Occurrence, days
     * @param $timeVisit    // integer, measured in spent at Occurrence site, days
     * Build and return an Investment object, provide realizations of the getters() & setters()
     * since this object will be "embedded" in a Milestone object, provide a general purpose
     * to return the Investment object itself
     */

    public function __construct($cost, $timeTravel, $timeVisit)
    {
        $this->_cost = $cost;
        $this->_timeTravel = $timeTravel;
        $this->_timeVisit = $timeVisit;
    }

    /**
     * @return integer amount of US dollars
     */
    public function getCost()
    {
        return $this->_cost;
    }

    /**
     * @return integer amount of days traveling, to/from the Occurrence site
     */
    public function getTimeTravel()
    {
        return $this->_timeTravel;
    }

    /**
     * @return integer amount of days spent on site at the Occurrence site
     */
    public function getTimeVisit()
    {
        return $this->_timeVisit;
    }

    /**
     * @param integer $cost in US dollars
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