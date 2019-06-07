<?php
/* Bruce Turner, Professor Ostrander, Spring 2019
 * IT 328 Full Stack Web Development
 * Final Project: with form validation & sticky forms
 * file: validation-functions.php
 * date: Friday, June 7 2019
 * "
 * validPOCname() checks to see that a string is all alphabetic
 * validNumberRange() checks to see that an value is numeric and between 1 and 10
 * validPhone() checks to see that a phone number is valid
 * (you can decide what constitutes a “valid” phone number)
 * validEmail() checks to see that an email address is valid
 * validOutdoor() checks each selected outdoor interest against a list of valid options
 * validIndoor() checks each selected indoor interest against a list of valid options
 * "
*/

/* Validate the POC information form
 * @return boolean
 */
function validInitialForm()
{
    global $f3;
    global $_SESSION;
    $isValid = true;

    if (!validPOCname($f3->get('pocName'))) {

        $isValid = false;
        $f3->set("errors['pocName']", "Please enter an alphabetic POC name");
    }
    else{
        $_SESSION['pocName'] = $_POST['pocName'];
    }

    if (!validPhoneNumber($f3->get('phone'))) {
        //require a number totaling 10 digits
        $isValid = false;
        $f3->set("errors['gender']", "Please select a gender");
    }
    else{
        $_SESSION['phone'] = $_POST['phone'];
    }

    if (!validEmail($f3->get('email'))) {

        $isValid = false;
        $f3->set("errors['email']", "Please enter an correct email address");
    }
    else{
        $_SESSION['email'] = $_POST['email'];
    }

    if (!validStreet($f3->get('streetAddress'))) {

        $isValid = false;
        $f3->set("errors['streetAddress']", "Please enter an alpha-numeric street address");
    }
    else{
        $_SESSION['streetAddress'] = $_POST['streetAddress'];
    }


    return $isValid;
}

    /* Validate a name string
     * @param String $name
     * @return boolean if name is not empty, and all alphabetic
     */
    function validPOCname($name)
    {
        return ctype_alpha($name) AND ($name != "");
    }

    /* Validate a street address value
     * @param String $streetAddress
     * @return boolean if streetAddress is alpha-numeric, for example "123 Main St)
     *
     */
    function validStreet($streetAddress)
    {
        return ctype_alnum($streetAddress) AND ($streetAddress != "");
    }

    /* validate an phone number value input as a string
     * @param String phone
     * @return boolean
     *
     */
    function validPhoneNumber($phone)
    {
        return !empty($phone) && ctype_digit($phone);
    }


    function validProfileForm()
    {
        global $f3;
        global $_SESSION;
        $isValid = true;

        if (!validSeekSex($f3->get('seekSex')))
        {
            $isValid = false;
            $f3->set("errors['seekSex']", "Please select the gender of your desired partner");
        }
        else {
            $_SESSION['seekSex'] = $_POST['seekSex'];
        }

        if (!validState($f3->get(resState)))
        {
            $isValid = false;
            $f3->set("errors['resState']", "Full spelling or state, or two letter abbreviation please");
        }
        else{
            $_SESSION['resState'] = $_POST['resState'];
        }
        return $isValid;
    }

    function validEmail($email)
    {
        // https://stackoverflow.com/questions/19261987/how-to-check-if-an-email-
        //address-is-real-or-valid-using-php/19262381
        // StackOverflow comment #33 Author: Machavity
        if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
            //Email is valid
            return true;
        }
        else {
            return false;
        }
    }

    function validSeekSex($seekSex)
    {
        return ctype_alpha($seekSex) AND ($seekSex != "");
    }

    function validState($resState)
    {
        global $f3;
        // insist on either the 2 letter abbreviation, or full state spelling
        if (in_array($resState,$f3->get('states')))
        {
            return true;
        }
        else if (in_array($resState,$f3->get('states_ABBR')))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    function validInterestsForm()
    {
        return true;
    }
    function validOutdoor($interest)
    {
        global $f3;
        if(!in_array($interest, $f3->get('outdoorInterests')))
        {
            //spoof attempt. skip it
            return false;
        }
        else{
            return true;
        }
    }

    function validIndoor($interest)
    {
        global $f3;
        if (!in_array($interest, $f3->get('indoorInterests'))) {
            //spoof attempt. skip it
            return false;
        } else {
            return true;
        }

    }