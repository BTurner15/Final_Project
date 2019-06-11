<?php
/**
 * Bruce Turner, Professor Ostrander, Spring 2019
 * IT 328 Full Stack Web Development
 * Final Project Assignment:
 * file: Location.php
 * date: Thursday, June 6 2019
 * class Location
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
class Location
{
    private $_POCName;          // a string of the name of point-of-contact
    private $_streetAddress;    // a string of the address of point-of-contact
    private $_city;             // a string of the city of point-of-contact
    private $_province;         // a string of the state, country, etc of point-of-contact
    private $_postalCode;       // a string of the "code" (zip, international #, etc) of point-of-contact
    /**
     * Location constructor.
     * @param $POCName
     * @param $streetAddress
     * @param $city
     * @param $province
     * @param $postalCode
     */
    public function __construct($POCName, $streetAddress, $city, $province, $postalCode)
    {
        $this->_POCName = $POCName;
        $this->_streetAddress = $streetAddress;
        $this->_city = $city;
        $this->_province = $province;
        $this->_postalCode = $postalCode;
    }

    /**
     * @return string (for example "Auburn")
     */
    public function getCity()
    {
        return $this->_city;
    }

    /**
     * @return string (for example "Manager, John Doe, Hotel California")
     */
    public function getPOCName()
    {
        return $this->_POCName;
    }

    /**
     * @return string (usually a zip code) (for "Hotel California")
     */
    public function getPostalCode()
    {
        return $this->_postalCode;
    }

    /**
     * @return string (a state in the US, various other meanings in rest of world)
     */
    public function getProvince()
    {
        return $this->_province;
    }

    /**
     * @return string (e.g. 123 Main Street #219) (for "Hotel California")
     */
    public function getStreetAddress()
    {
        return $this->_streetAddress;
    }

    /**
     * @param string $city ("Los Angeles")
     */
    public function setCity($city)
    {
        $this->_city = $city;
    }

    /**
     * @param string $POCName ("Manager, John Doe, Hotel California")
     */
    public function setPOCName($POCName)
    {
        $this->_POCName = $POCName;
    }

    /**
     * @param string $postalCode (zip, etc)
     */
    public function setPostalCode($postalCode)
    {
        $this->_postalCode = $postalCode;
    }

    /**
     * @param string $province (can be "WA", or "BULGARIA")
     */
    public function setProvince($province)
    {
        $this->_province = $province;
    }

    /**
     * @param string $streetAddress (this validated for international is difficult!)
     */
    public function setStreetAddress($streetAddress)
    {
        $this->_streetAddress = $streetAddress;
    }
}