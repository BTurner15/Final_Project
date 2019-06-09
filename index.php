<?php
/* Bruce Turner, Professor Ostrander, Spring 2019
 * IT 328 Full Stack Web Development
 * Final Project: Bucket of Milestones
 * file: index.php  is the default landing page, defines various routes
 * date: Sunday,June 9 2019
*/
//3456789_123456789_123456789_123456789_123456789_123456789_123456789_1234567890
// the above is 80 characters
ini_set('display_errors', 1);
error_reporting(E_ALL);


//Require auto-loads
require_once('vendor/autoload.php');
require_once('model/validation-functions.php');

//Start a session
session_start();

$f3 = Base::instance();
/*
//Turn on Fat-Free error reporting
set_exception_handler(function($obj) use($f3){
    $f3->error(500,$obj->getmessage(),$obj->gettrace());
});
set_error_handler(function($code,$text) use($f3)
{
    if (error_reporting())
    {advent
        $f3->error(500,$text);
    }
});
*/
$f3->set('DEBUG', 3);

$f3->set('positives', array('adventurous', 'quirky', 'challenging', 'always wanted to',
                       ' expand horizons', 'told I could not'));

$f3->set('negatives', array('physically demanding', 'costly', 'temporal concerns', 'vaccinations current',
    'passport', 'could be fatal', 'illegal'));

//Define a default route
$f3->route('GET /', function(){
    //don't want any lingering session information
    $_SESSION = array();

    //display landing page Template, which POSTS to personal information
    $view = new Template();
    echo $view->render('views/home.html');

});

//Define a debug route
$f3->route('GET|POST /debug', function() {
    //our debug route
    global $_SESSION;
    /*
    //start with a milestone object. test getters & setters
    $ms = new Milestone( '1', 'Meet Grandson', '9', 'Sara', '715 Main Street', 'Philadelphia', 'PA', '19086',
        '1125', '2', '7', '1', '9', '2019', 'summer', 'images/MT Pose.jpg', 0
    );

    $_SESSION['ms'] = $ms;
    $name = 'Summer Turner';
    $isValid = ctype_alpha($name);
    if($isValid == 0)echo'NOT SET';
    if($isValid == 1)echo'SET';
    //$view = new Template();
    //echo $view->render('views/debug.html');
    */
    $title = $_SESSION['ms']->getTitle();
    echo 'title: '.$title.'<br>';

    $priority = $_SESSION['ms']->getPriority();
    echo 'priority: '.$priority.'<br>';

    $pocName = $_SESSION['ms']->getLocation()->getPOCName();
    echo 'pocName: '.$pocName.'<br>';

    $streetAddress = $_SESSION['ms']->getLocation()->getStreetAddress();
    echo 'streetAddress: '.$streetAddress.'<br>';

    $city = $_SESSION['ms']->getLocation()->getCity();
    echo 'city: '.$city.'<br>';

    $province = $_SESSION['ms']->getLocation()->getProvince();
    echo 'province: '.$province.'<br>';

    $postalCode= $_SESSION['ms']->getLocation()->getPostalCode();
    echo 'postalCode: '.$postalCode.'<br>';

    $cost= $_SESSION['ms']->getInvestment()->getCost();
    echo ' cost: '.$cost.'<br>';

    $timeTravel = $_SESSION['ms']->getInvestment()->getTimeTravel();
    echo ' timeTravel: '.$timeTravel.'<br>';

    $timeVisit = $_SESSION['ms']->getInvestment()->getTimeVisit();
    echo ' timeVisit: '.$timeVisit.'<br>';

    $day = $_SESSION['ms']->getOccurence()->getDay();
    echo ' day: '.$day.'<br>';

    $month = $_SESSION['ms']->getOccurence()->getMonth();
    echo ' month: '.$month.'<br>';

    $year = $_SESSION['ms']->getOccurence()->getYear();
    echo ' year: '.$year.'<br>';

    $image = $_SESSION['ms']->getImage();
    echo ' image: '.$image.'<br>';

    $ongoing = $_SESSION['ms']->getOngoing();
    echo ' ongoing: '.$ongoing.'<br>';

});

//Define a route to display the entire bucket
$f3->route('GET /view', function($f3)
{
    global $dbM;

    $dbM = new MilestoneDB();

    $milestones = $dbM->getMilestones();
    $f3->set('milestones', $milestones);

    $view = new Template();
    echo $view->render('views/all-milestones.html');
});

//Define a route to display one milestone using an ID#
$f3->route('GET /displayOne/@milestone_id', function($f3, $params)
{
        global $dbM;
        $dbM = new MilestoneDB();
        $milestone_id = $params['milestone_id'];
        $row = $dbM->getMilestone($milestone_id);

        if($row['ongoing']==0) {
            $ms = new Milestone($row['id'], $row['title'], $row['priority'], $row['pocName'],
                $row['streetAddress'], $row['city'], $row['province'],
                $row['postalCode'], $row['cost'], $row['timeTravel'], $row['timeVisit'],
                $row['day'], $row['month'], $row['year'],
                $row['image'], $row['ongoing']);

            $_SESSION['ms'] = $ms;
            $view = new Template();
            echo $view->render('views/milestone-summary.html');
        }
        else {
            $pros = array();
            $cons = array();
            $ms = new OngoingMilestone($row['id'], $row['title'], $row['priority'], $row['pocName'],
                $row['streetAddress'], $row['city'], $row['province'],
                $row['postalCode'], $row['cost'], $row['timeTravel'], $row['timeVisit'],
                $row['day'], $row['month'], $row['year'],
                $row['image'], $row['ongoing'], $pros, $cons);
            $_SESSION['ms'] = $ms;

            $view = new Template();
            echo $view->render('views/ongoingMS-summary.html');
        }
    });

//define a route to display & process the POC form
//stay in this route until either rerouted Home vis nav-bar, or
// continue to next milestone form if an ongoing milestone
$f3->route('GET|POST /form_1', function($f3)
{
    // will stay in this outer conditional until we have a valid milestone
    // point-of-contact (POC) section of information
    if(!empty($_POST)) {
        //Get data from form
        $title = $_POST['title'];
        $image = $_POST['image'];
        $day = $_POST['day'];
        $month = $_POST['month'];
        $year = $_POST['year'];
        $cost = $_POST['cost'];
        $timeTravel = $_POST['timeTravel'];
        $timeVisit = $_POST['timeVisit'];

        //Add data to hive
        $f3->set('title', $title);
        $f3->set('image', $image);
        $f3->set('day', $day);
        $f3->set('month', $month);
        $f3->set('year', $year);
        $f3->set('cost', $cost);
        $f3->set('timeTravel', $timeTravel);
        $f3->set('timeVisit', $timeVisit);

        if (validPOCform()) {

            //Write data to Session
            $_SESSION['title'] = $_POST['title'];
            $_SESSION['image'] = $_POST['image'];
            $_SESSION['day'] = $_POST['day'];
            $_SESSION['month'] = $_POST['month'];
            $_SESSION['year'] = $_POST['year'];
            $_SESSION['cost'] = $_POST['cost'];
            $_SESSION['timeTravel'] = $_POST['timeTravel'];
            $_SESSION['timeVisit'] = $_POST['timeVisit'];

            //need more data from the second form

            $f3->reroute('https://bturner.greenriverdev.com/328/Final_Project/form_2');
        }
    }
    $view = new Template();
    echo $view->render('views/required-data_1.html');
});
// define a route to display & process the POC form
// stay in this route until either rerouted Home via nav-bar, or
// continue to next OngoingMilestone form depending on the infamous button
$f3->route('GET|POST /form_2', function($f3)
{
    global $dbM;

    // will stay in this outer conditional until we have a valid
    // point-of-contact (POC) section of information
    if(!empty($_POST)) {
        //Get data from form
        $pocName = $_POST['pocName'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $streetAddress = $_POST['streetAddress'];
        $city = $_POST['city'];
        $province = $_POST['province'];
        $postalCode = $_POST['postalCode'];
        //Ok this one bit me before. If the Ongoing Milestone was NOT set if the form,
        //then $_POST['ongoing'] does not exist
        //Add data to hive
        $f3->set('pocName', $pocName);
        $f3->set('phone', $phone);
        $f3->set('email', $email);
        $f3->set('streetAddress', $streetAddress);
        $f3->set('city', $city);
        $f3->set('province', $province);
        $f3->set('postalCode', $postalCode);
        if (validSecondForm()) {

            //Write data to Session
            $_SESSION['pocName'] = $_POST['pocName'];
            $_SESSION['phone'] = $_POST['phone'];
            $_SESSION['email'] = $_POST['email'];
            $_SESSION['streetAddress'] = $_POST['streetAddress'];
            $_SESSION['city'] = $_POST['city'];
            $_SESSION['province'] = $_POST['province'];
            $_SESSION['postalCode'] = $_POST['postalCode'];

            // !ongoing will be true ONLY THIS TIME until submitted
            // Fat-Free does NOT allocate storage for a "false" value

            //be careful here, if it is not set it doesnt exist!
            $_SESSION['ongoing'] = -1;
            if(!isset($_POST['ongoing']))
            {
                $_SESSION['ongoing'] = "0";
                $ongoing = 0;
            }
            else {
                $_SESSION['ongoing'] = "1";
                $ongoing = 1;
            }
            $f3->set('ongoing', $ongoing);
            //get the next ID
            $nextMS_id = $dbM->lastInsertId() + 1;
            echo $nextMS_id;

            //we only need more data if this is an ongoing milestone, otherwise add & display
            if($_SESSION['ongoing'] == 1){
                $pros = array();
                $cons = array();
                $ms = new OngoingMilestone($nextMS_id, $_SESSION['title'], $_SESSION['priority'], $_SESSION['pocName'],
                    $_SESSION['streetAddress'], $_SESSION['city'], $_SESSION['province'],
                    $_SESSION['postalCode'], $_SESSION['cost'], $_SESSION['timeTravel'], $_SESSION['timeVisit'],
                    $_SESSION['day'], $_SESSION['month'], $_SESSION['year'],
                    $_SESSION['image'], $_SESSION['ongoing'], $pros, $cons);
                $f3->reroute('/ongoingMS-summary');
             }
            else {
                //instantiate a new Milestone
                $ms = new Milestone($nextMS_id, $_SESSION['title'], $_SESSION['priority'], $_SESSION['pocName'],
                    $_SESSION['streetAddress'], $_SESSION['city'], $_SESSION['province'],
                    $_SESSION['postalCode'], $_SESSION['cost'], $_SESSION['timeTravel'], $_SESSION['timeVisit'],
                    $_SESSION['day'], $_SESSION['month'], $_SESSION['year'],
                    $_SESSION['image'], $_SESSION['ongoing']);
            }
            $_SESSION['ms'] = $ms;
            $f3->set('ms', $ms);
            //$dbM->insertMS($nextMS_id);
            if($_SESSION['ongoing'] == 0)
                $f3->reroute('/displayOne/@nextMS_id');
            else
                $f3->reroute('/ongoingMS/@nextMS_id');
        }
    }
    $view = new Template();
    echo $view->render('views/required-data_2.html');
});

//Run fat free
$f3->run();