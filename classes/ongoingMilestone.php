<?php
/**
 * Bruce Turner, Professor Ostrander, Spring 2019
 * IT 328 Full Stack Web Development
 * Final Project Assignment:
 * file: ongoingMilestone.php
 * date: Sunday, June 9 2019
 * class OngoingMilestone
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

class OngoingMilestone extends Milestone
{
    /*  private methods and properties are NOT inherited. */
    /* protected methods & properties ARE inherited */
    /**
     * Here we will leverage PHP inheritance, because a OngoingMilestone really is (and starts as) a Milestone,
     * then has additional fields (variables) the two arrays of selected interests (indoor[] & outdoor[])
     * Thus there is an embedded invoking of the Member class
     *
     * @param $_pros
     * @param $_cons
     */
    public function __construct($id, $title, $priority, $POCName, $streetAddress, $city,
                                $province, $postalCode, $cost, $timeTravel, $timeVisit, $day,
                                $month, $year, $image, $ongoing,
                                $pros = "", $cons = "")
    {
        //set parent constructor values
        parent::__construct($id, $title, $priority, $POCName, $streetAddress, $city,
                            $province, $postalCode, $cost, $timeTravel, $timeVisit, $day,
                            $month, $year, $image, $ongoing);

        $this->_pros = $pros;
        $this->_cons = $cons;
    }
    /**
     * retrieve the list of positive attributes selected for this ongoing milestone
     * @return string pointer to something like "challenging..."
     */
    public function getPros()
    {
        return $this->_pros;
    }

    /**
     * retrieve the list of concerns selected for this ongoing milestone
     * @return string pointer to something like "cost"
     */
    public function getCons()
    {
        return $this->_cons;
    }

    /**
     * store the list of positive attributes selected for this ongoing milestone
     * @param string $pros
     */
    public function setPros($pros)
    {
        $this->_pros = $pros;
    }

    /**
     * store the list of "concerns" selected for this ongoing milestone
     * @param string $cons
     */
    public function setCons($cons)
    {
        $this->_cons = $cons;
    }
}