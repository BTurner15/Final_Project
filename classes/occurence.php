<?php
/**
 * Bruce Turner, Professor Ostrander, Spring 2019
 * IT 328 Full Stack Web Development
 * Final Project Assignment:
 * file: Occurence.php
 * date: Thursday, June 6 2019
 * class Occurence
 *
 * Here I want to conform to the required PEAR coding standards from the git go
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

class Occurence
{
    private $_day;      //first day of event
    private $_month;    //month event occurs
    private $_year;     //year
    private $_season;   // one of: 'Fall', 'Winter', 'Spring', 'Summer', or 'All year'
    /**
     * Occurence constructor.
     * @param $day
     * @param $month
     * @param $year
     * @param $season
     *
     * */
    public function __construct($day, $month, $year, $season)
    {
        $this->_day = $day;
        $this->_month = $month;
        $this->_year = $year;
        $this->_season = $season;
    }

    /**
     * @return integer
     */
    public function getDay()
    {
        return $this->_day;
    }

    /**
     * @return integer
     */
    public function getMonth()
    {
        return $this->_month;
    }

    /**
     * @return string
     */
    public function getSeason()
    {
        return $this->_season;
    }

    /**
     * @return integer
     */
    public function getYear()
    {
        return $this->_year;
    }

    /**
     * @param integer $day
     */
    public function setDay($day)
    {
        $this->_day = $day;
    }

    /**
     * @param integer $month
     */
    public function setMonth($month)
    {
        $this->_month = $month;
    }

    /**
     * @param string $season
     */
    public function setSeason($season)
    {
        $this->_season = $season;
    }

    /**
     * @param integer $year
     */
    public function setYear($year)
    {
        $this->_year = $year;
    }
}