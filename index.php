<?php
/* Bruce Turner, Professor Ostrander, Spring 2019
 * IT 328 Full Stack Web Development
 * Final Project: Bucket of Milestones
 * file: index.php  is the default landing page, defines various routes
 * date: Monday,June 10 2019
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


    //start with a milestone object. test getters & setters
    $ms = new Milestone('Test Data Structure', '1',
        'Buckaroo', '106th Street NE', 'Auburn', 'WA', 19086,
        10000, 1, 21, 31, 12, 2021,
        'images/MT Pose.jpg', 0);

    $_SESSION['ms'] = $ms;

    $_SESSION['title'] = $ms->getTitle();
    $_SESSION['Priority'] = $ms->getPriority();
    $_SESSION['POCName'] = $ms->getLocation()->getPOCName();
    $_SESSION['city'] = $ms->getLocation()->getCity();
    $_SESSION['streetAddress'] = $ms->getLocation()->getStreetAddress();
    $_SESSION['province'] = $ms->getLocation()->getProvince();
    $_SESSION['postalCode'] = $ms->getLocation()->getPostalCode();
    $_SESSION['cost'] = $ms->getInvestment()->getCost();
    $_SESSION['timeTravel'] = $ms->getInvestment()->getTimeTravel();
    $_SESSION['timeVisit'] = $ms->getInvestment()->getTimeVisit();
    $_SESSION['day'] = $ms->getOccurence()->getDay();
    $_SESSION['month'] = $ms->getOccurence()->getMonth();
    $_SESSION['year'] = $ms->getOccurence()->getYear();
    $_SESSION['image'] = $ms->getImage();
    $_SESSION['ongoing'] = $ms->getOngoing();
    //print_r($_SESSION['ms']);
/*
    $pros = array('1st', '2nd', '3rd', '4th', '5th');
    $cons = array('c1','c2','c3', 'c4', 'c5');
    $ms2 = new OngoingMilestone( 'OM for Summer Doodle', 10, 'Buckaroo',
        '106 10th Street', 'Auburn', 'WA', 98002, 10000,
        1, 1, 1, 1, 2020,
        'images/Summer.jpg', 1, $pros, $cons);


    //$_SESSION['id_2'] = $ms2->getID();
    $_SESSION['title_2'] = $ms2->getTitle();
    $_SESSION['priority_2'] = $ms2->getPriority();
    $_SESSION['POCName_2'] = $ms2->getLocation()->getPOCName();
    $_SESSION['city_2'] = $ms2->getLocation()->getCity();
    $_SESSION['streetAddress_2'] = $ms2->getLocation()->getStreetAddress();
    $_SESSION['province_2'] = $ms2->getLocation()->getProvince();
    $_SESSION['postalCode_2'] = $ms2->getLocation()->getPostalCode();
    $_SESSION['cost_2'] = $ms2->getInvestment()->getCost();
    $_SESSION['timeTravel_2'] = $ms2->getInvestment()->getTimeTravel();
    $_SESSION['timeVisit_2'] = $ms2->getInvestment()->getTimeVisit();
    $_SESSION['day_2'] = $ms2->getOccurence()->getDay();
    $_SESSION['month_2'] = $ms2->getOccurence()->getMonth();
    $_SESSION['year_2'] = $ms2->getOccurence()->getYear();
    $_SESSION['image_2'] = $ms2->getImage();
    $_SESSION['ongoing_2'] = $ms2->getOngoing();
    $_SESSION['ms2'] = $ms2;
    print_r($_SESSION['ms2']);
*/

    $view = new Template();
    echo $view->render('views/debug.html');


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
            $ms = new Milestone($row['title'], $row['priority'], $row['pocName'],
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

        if (validPOCform2()) {
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

            $f3->reroute('/form_2');
        } //https://bturner.greenriverdev.com/328/Final_Project/form_2
    }
    $view = new Template();
    echo $view->render('views/required-data_1.html');
});
// define a route to display & process the contact information form
$f3->route('GET|POST /form_2', function($f3)
{
    global $dbM;
    $dbM = new MilestoneDB();
    // will stay in this outer conditional until we have a valid
    // point-of-contact (POC) section of information
    if(!empty($_POST)) {
        //Get data from form 2
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

        if (validSecondForm2()) {

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
            }
            else {
                $_SESSION['ongoing'] = "1";
            }
            //get the next ID
            //$nextMS_id = $dbM->lastInsertId() + 1;
            //echo $nextMS_id;

            //we only need more data if this is an OngoingMilestone, otherwise add & display
            if($_SESSION['ongoing'] == 1){
                $pros = array();
                $cons = array();
                $ms = new OngoingMilestone($_SESSION['title'], $_SESSION['priority'], $_SESSION['pocName'],
                    $_SESSION['streetAddress'], $_SESSION['city'], $_SESSION['province'],
                    $_SESSION['postalCode'], $_SESSION['cost'], $_SESSION['timeTravel'], $_SESSION['timeVisit'],
                    $_SESSION['day'], $_SESSION['month'], $_SESSION['year'],
                    $_SESSION['image'], $_SESSION['ongoing'], $pros, $cons);
             }
            else {
                //instantiate a new Milestone
                $ms = new Milestone($_SESSION['title'], $_SESSION['priority'], $_SESSION['pocName'],
                    $_SESSION['streetAddress'], $_SESSION['city'], $_SESSION['province'],
                    $_SESSION['postalCode'], $_SESSION['cost'], $_SESSION['timeTravel'], $_SESSION['timeVisit'],
                    $_SESSION['day'], $_SESSION['month'], $_SESSION['year'],
                    $_SESSION['image'], $_SESSION['ongoing'], "", "");
            }
            $_SESSION['ms'] = $ms;
            $dbM->insertMS();
            $f3->reroute('https://bturner.greenriverdev.com/328/Final_Project');
        }
    }
    $view = new Template();
    echo $view->render('views/required-data_2.html');
});
//Define a route to display one milestone using an ID#
$f3->route('GET /deleteOne/@milestone_id', function($f3, $params)
{
    global $dbM;
    $dbM = new MilestoneDB();
    $milestone_id = $params['milestone_id'];
    $result = $dbM->deleteMilestone($milestone_id);

    $view = new Template();
    echo $view->render('views/home.html');
});

//Run fat free
$f3->run();