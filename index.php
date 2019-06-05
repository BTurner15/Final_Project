<?php
/* Bruce Turner, Professor Ostrander, Spring 2019
 * IT 328 Full Stack Web Development
 * Final Project: Bucket of Milestones
 * file: index.php  is the default landing page, defines various routes
 * date: Tuesday, June 4 2019
*/
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
    //display landing page Template, which POSTS to personal information
    $view = new Template();
    echo $view->render('views/carousel.html');
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

$f3->route('GET /displayOne/@milestone_id', function($f3, $params)
{
        global $dbM;

        $dbM = new MilestoneDB();

        $milestone_id = $params['milestone_id'];
        $milestone = $dbM->getMilestone($milestone_id);
        print_r($milestone);
        /*
        $_SESSION['milestone'] = $milestone;
        $f3->set('milestone', $milestone);

        $f3->set('fname', $member->getFname());
        $f3->set('lname', $member->getLname());
        $f3->set('age', $member->getAge());
        $f3->set('gender', $member->getGender());
        $f3->set('phone', $member->getPhone());
        $f3->set('email', $member->getEmail());
        $f3->set('state', $member->getState());
        $f3->set('seeking', $member->getSeeking());
        $f3->set('bio', $member->getBio());

        //if this is a premium member include other field information
        if (get_class($member) == "PremiumMember")
        {
            $f3->set('indoor', $member->getInDoor());
            $f3->set('outdoor', $member->getOutDoor());
        }

        $view = new Template();
        echo $view->render('views/summary.html');
        */
    });
//Run fat free
$f3->run();