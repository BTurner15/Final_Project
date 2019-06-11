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
/*
 * the constructor. I am embarrassed I misspelled the word. My bad.
 */
class Occurence
{
    private $_day;      //first day of event
    private $_month;    //month event occurs
    private $_year;     //year event occurs
    /**
     * Occurence constructor.
     * @param $day
     * @param $month
     * @param $year
     *
     * */
    public function __construct($day, $month, $year)
    {
        $this->_day = $day;
        $this->_month = $month;
        $this->_year = $year;
    }

    /**
     * @return integer day (1...31) event occurs (is scheduled to)
     */
    public function getDay()
    {
        return $this->_day;
    }

    /**
     * @return integer month (1..12) event occurs (is scheduled to)
     */
    public function getMonth()
    {
        return $this->_month;
    }

    /**
     * @return integer year event occurs (is scheduled to occur)
     */
    public function getYear()
    {
        return $this->_year;
    }

    /**
     * @param integer $day of event (1...31)(is scheduled to occur)
     */
    public function setDay($day)
    {
        $this->_day = $day;
    }

    /**
     * @param integer $month of event (1...12)(is scheduled to occur)
     */
    public function setMonth($month)
    {
        $this->_month = $month;
    }

    /**
     * @param integer $year(is scheduled to) occur
     */
    public function setYear($year)
    {
        $this->_year = $year;
    }
}