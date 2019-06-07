<?php
/* Bruce Turner, Professor Ostrander, Spring 2019
 * IT 328 Full Stack Web Development
 * Final Project: Bucket of Milestones
 * file: index.php  is the default landing page, defines various routes
 * date: Thursday, June 6 2019
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
        echo $view->render('views/debug.html');

    });
//define an add milestone route
$f3->route('GET|POST /add', function($f3)
{
    global $dbM;

    $dbM = new MilestoneDB();
    $table = $dbM->getMilestones();
    $f3->set('table', $table);

    // will stay in this outer conditional until we have a valid milestone
    // first section of information
    if(!empty($_POST)) {
        //Get data from form
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];

        $phone = $_POST['phone'];

        //Add data to hive
        $f3->set('fname', $fname);
        $f3->set('lname', $lname);

        $f3->set('phone', $phone);

        if (validPerinfoForm()) {

            //Write data to Session
            $_SESSION['fname'] = $_POST['fname'];
            $_SESSION['lname'] = $_POST['lname'];

            $_SESSION['phone'] = $_POST['phone'];

            //now fold in the classes...parse on PremiumMember checkbox, if we are in a  mode with
            //an "ordinary" Member then !premium will be true ONLY THIS TIME until submitted

            //be careful here, if it is not set it doesnt exist!
            if(!isset($_POST['ongoing']))
            {
                $ms = new Milestone($_SESSION['fname'],$_SESSION['lname'],
                                     $_SESSION['phone']);
                                     $_SESSION['memberType'] = "0";

            }
            else
            {
                $ms = new OngoingMilestone($_SESSION['fname'],$_SESSION['lname'],
                                           $_SESSION['phone']);
                $_SESSION['ongoing'] = "1";
            }
            //store the individual either way

            $_SESSION['ms'] = $ms;

            //print_r($_SESSION['ongoing'] == true);
            //we are only going to store in the $_SESSION[] NOT $f3->set('ms', $ms);
            //need more data regardless of milestone (ms) type

            $f3->reroute('/required-data');
        }
    }
    $view = new Template();
    echo $view->render('views/add-milestone.html');
});
//Run fat free
$f3->run();