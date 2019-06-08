<?php
/* Bruce Turner, Professor Ostrander, Spring 2019
 * IT 328 Full Stack Web Development
 * Final Project: Bucket of Milestones
 * file: index.php  is the default landing page, defines various routes
 * date: Saturday, June 8 2019
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
    {
        $f3->error(500,$text);
    }
});
*/
$f3->set('DEBUG', 3);

$f3->set('searchCriteria', array('priority', 'cost', 'temporal'));

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
    //start with a milestone object. test getters & setters
    $ms = new Milestone( '1', 'Meet Grandson', '9', 'Sara', '715 Main Street', 'Philadelphia', 'PA', '19086',
        '1125', '2', '7', '1', '9', '2019', 'summer', 'images/MT Pose.jpg', 0
    );

    $_SESSION['ms'] = $ms;

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

        $ms = new Milestone($row['id'], $row['title'], $row['priority'], $row['pocName'],
                            $row['streetAddress'], $row['city'], $row['province'],
                            $row['postalCode'], $row['cost'], $row['timeTravel'], $row['timeVisit'],
                            $row['day'], $row['month'], $row['year'], $row['season'],
                            $row['image'], $row['ongoing']);

        $_SESSION['ms'] = $ms;

        $view = new Template();
        echo $view->render('views/milestone-details.html');

    });
//define an add milestone route
$f3->route('GET|POST /add', function($f3)
{
    global $dbM;

    $dbM = new MilestoneDB();
    $table = $dbM->getMilestones();
    $f3->set('table', $table);

    // will stay in this outer conditional until we have a valid milestone
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

        //Add data to hive
        $f3->set('pocName', $pocName);
        $f3->set('phone', $phone);
        $f3->set('email', $email);
        $f3->set('streetAddress', $streetAddress);
        $f3->set('city', $city);
        $f3->set('province', $province);
        $f3->set('postalCode', $postalCode);

        if (validInitialForm()) {

            //Write data to Session
            $_SESSION['pocName'] = $_POST['pocName'];
            $_SESSION['phone'] = $_POST['phone'];
            $_SESSION['email'] = $_POST['email'];
            $_SESSION['streetAddress'] = $_POST['streetAddress'];
            $_SESSION['city'] = $_POST['city'];
            $_SESSION['province'] = $_POST['province'];
            $_SESSION['postalCode'] = $_POST['postalCode'];
            //now fold in the classes...parse on OngoingMilestone checkbox, if we are in a  mode with
            //an "ordinary" Milestone then !ongoing will be true ONLY THIS TIME until submitted
            //Fat-Free does NOT waste storage for a "false" value

            //be careful here, if it is not set it doesnt exist!
            if(!isset($_POST['ongoing'])) {$_SESSION['ongoing'] = "0"; $ongoing = 1;}
            else {$_SESSION['ongoing'] = "1"; $ongoing = 0;}

            $f3->set('ongoing', $ongoing);
            //need more data regardless of milestone (ms) type

            $f3->reroute('/milestone-profile');
        }
    }
    $view = new Template();
    echo $view->render('views/required-data.html');
});

$f3->route('GET|POST /milestone-profile', function($f3) {
    global $dbM;

});
//Run fat free
$f3->run();