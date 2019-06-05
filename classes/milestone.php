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
        $this->_occurance = $occurance;
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
 * returns the string used to locate the image associated with this milestone
 * @return string
 */
public function getImage()
{
    return $this->_image;
}


}