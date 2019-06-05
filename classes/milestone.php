<?php


class Milestone
{
    private $_id;
    private $_title;
    private $_priority;
    private $_location;
    private $_investment;
    private $_occurance;
    private $_image;
    private $_ongoing;

    /**
     * Milestone constructor.
     * @param $id
     * @param $title
     * @param $priority
     * @param $location
     * @param $investment
     * @param $occurance
     * @param $image
     * @param $ongoing
     */
    public function __construct($id, $title, $priority, $location = "", $investment = "",
                                $occurance = "", $image, $ongoing = "")
    {
        $this->_id = $id;
        $this->_title = $title;
        $this->_priority = $priority;
        $this->_location = $location;
        $this->_investment = $investment;
        $this->_occurence = $occurance;
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
// getOccurance()
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

    /**
     * returns a Location object
    */

    /**
    * returns a Occrance object
    */
    public function getOccurance()
    {
        return $this->occurence;
    }
    /**
     * returns whether the milestone if "ongoing", no set beginning & end
     */
    public function getOngoing()
    {
        return $this->_investment;
    }
    /**
     * returns the Priority on scale of 1...10
     *
     */
    public function getPriority()
    {
        return $this->_ongoing;
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
     * set to an Investment object
     * @param integer cost in US dollars
     * @param int timeTravel in days traveling both ways to the SITE (for Duration)
     * @param int $timeVisit in days ON SITE (for Duration)
     */
    public function setInvestment($cost, $timeTravel, $timeVisit)
    {
        // be care full about the order of instantiating
        // Duration is a child of Investment, the "leaf" of the class(es)

        $duration = new Duration($timeTravel, $timeVisit);
        $duration->setTimeTravel($timeTravel);
        $duration->setTimeVisit($timeVisit);
        $investment = new Investment($cost, $timeTravel, $timeVisit);
        $investment->setCost($cost);
    }
    /**
     * returns a Location object
     */

    /**
     * returns a Occrance object
     */
    public function setOccurance()
    {
        $occurence = new Occurence();
        $this->_occurence = $occurence;
    }
    /**
     * sets the milestone if "ongoing", no set beginning & end
     */
    public function setOngoing()
    {
        $investment = new Investment();
        $this->_investment = $investment;
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

// getTitle()