<?php
/**
 * Bruce Turner, Professor Ostrander, Spring 2019
 * IT 328 Full Stack Web Development
 * Final Project Assignment:
 * file: Milestone.php
 * date: Thursday, June 6 2019
 * class Milestone
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
class Milestone
{
    private $_id;
    private $_title;
    private $_priority;
    private $_location;
    private $_investment;
    private $_occurence;
    private $_image;
    private $_ongoing;

    /**
     * Milestone constructor.
     * @param $id
     * @param $title
     * @param $priority
     * @param $POCName (for Location constructor)
     * @param $streetAddress (for Location constructor)
     * @param $city (for Location constructor)
     * @param $province (for Location constructor)
     * @param $postalCode (for Location constructor)
     * @param $day (for Occurence constructor 1..31)
     * @param $month (for Occurence constructor 1...12)
     * @param $year (for Occurence constructor YYYY)
     * @param $season ('Fall', 'Winter', 'Spring', 'Summer', or 'All year')
     * @param $cost (for Investment constructor, US dollars estimate)
     * @param $timeTravel (for Investment constructor, day spent both ways)
     * @param $timeVisit (for Investment constructor, total days anticipated
     * @param $image
     * @param $ongoing
     */
    public function __construct($id, $title, $priority, $POCName, $streetAddress, $city,
                                $province, $postalCode, $cost, $timeTravel, $timeVisit, $day,
                                $month, $year, $season, $image, $ongoing)
    {
        $this->_id = $id;
        $this->_title = $title;
        $this->_priority = $priority;
        $this->_location = new Location($POCName, $streetAddress, $city, $province, $postalCode );
        $this->_investment = new Investment($cost, $timeTravel, $timeVisit);
        $this->_occurence = new Occurence($day, $month, $year, $season);
        $this->_image = $image;
        $this->_ongoing = $ongoing;
    }
    //we are instructed to write our own setters and getters, thus the above eight
    //data (attributes) will be logical extensions of their respective names. Here
    //impose some alphabetical order to aid in locating the methods (mutator).
    //Presentation of the methods will be ordered:
    //
    // getId()
    // getImage()
    // getInvestment()
    // getLocation()
    // getOccurence ()
    // getOngoing()
    // getPriority()
    // getTitle()
    /**
     * returns the PRIMARY KEY identification number
    * @return int
    */
    public function getID()
    {
        return $this->_id;
    }
    /**
    *  returns the string used to locate the image associated with this milestone
    * @return string
    */
    public function getImage()
    {
        return $this->_image;
    }
    /**
    * returns a Investment object
    */
    public function getInvestment()
    {
        return $this->_investment;
    }
    /**
     * returns a Location object
    */
    public function getLocation()
    {
        return $this->_location;
    }
    /**
    * returns a Occrence object
    */
    public function getOccurence()
    {
        return $this->_occurence;
    }
    /**
     * returns whether the milestone if "ongoing", no set beginning & end
     */
    public function getOngoing()
    {
        return $this->_ongoing;
    }
    /**
     * returns the Priority on scale of 1...10
     *
     */
    public function getPriority()
    {
        return $this->_priority;
    }
    /**
     * returns the title of the milestone
     */
    public function getTitle()
    {
        return $this->_title;
    }
    /**
     * sets the PRIMARY KEY identification number
     * @param int id
     */
    public function setID($id)
    {
        $this->_id = $id;
    }
    /**
     *  sets the string used to locate the image associated with this milestone
     * @param string
     */
    public function setImage($image)
    {
        $this->_image = $image;
    }

    /**
     * sets the milestone if "ongoing", no set beginning & end
     */
    public function setOngoing($ongoing)
    {
        $this->_ongoing = $ongoing;
    }
    /**
     * sets the Priority on scale of 1...10
     *
     */
    public function setPriority($priority)
    {
        $this->_priority = $priority;
    }
    /**
     * sets the title of the milestone
     */
    public function setTitle($title)
    {
        $this->_title = $title;
    }
}
