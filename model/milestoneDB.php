<?php
/**
 * Bruce Turner, Professor Ostrander, Spring 2019
 * IT 328 Full Stack Web Development
 * Bucket app handling the "milestones" in the DB:
 * file: milestoneDB.php
 * date: Thursday, June 6 2019
 * class MilestoneDB
 *
 * Conform to the required PEAR coding standards from the git go
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
/*
 * //"Copy your CREATE TABLE statements into a block comment at the top of your
 * //Milestone class."

CREATE TABLE bucket(`id` int PRIMARY KEY,
                       `title` varchar(72) DEFAULT NULL,
                       `priority` tinyint DEFAULT NULL,
                       `pocName` varchar(40) DEFAULT NULL,
                       `streetAddress` varchar(40) DEFAULT NULL,
                       `city` varchar(40) DEFAULT NULL,
                       `province` varchar(40) DEFAULT NULL,
                       `postalCode` int DEFAULT NULL,
                       `cost` int DEFAULT NULL,
                       `timeTravel` int DEFAULT NULL,
                       `timeVisit` int DEFAULT NULL,
                       `day` int DEFAULT NULL,
                       `month` int DEFAULT NULL,
                       `year` int DEFAULT NULL,
                       `season` varchar(8) DEFAULT NULL,
                       `image` varchar(255) DEFAULT NULL,
                       `ongoing` tinyint DEFAULT NULL
                        );
*/
// Provide the database connection with the required database credentials
// stored as constants outside of public_html
require('/home/bturnerg/config.php');

class MilestoneDB
{

    function __construct()
    {
        $this->connect();
    }

    /**
     * establish a data base connection
     */

    function connect()
    {
        try {
            //Instantiate a database object
            $dbM = new PDO(DB_DSN, DB_USERNAME,
                DB_PASSWORD);
            //echo "Connected to database!!!";
            return $dbM;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return;
        }
    }

    function getLastID()
    {
        global $dbM;

        $dbM = $this->connect();
        // 1. define the query
        $sql = "SELECT LAST_INSERT_ID()";
        // 2. prepare the statement
        $statement = $dbM->prepare($sql);
        // 3. bind parameters

        // 4. execute the statement
        $statement->execute();
        // 5. return the result
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        $milestoneID = row[0];
        return $milestoneID;

    }

    function getMilestoneID($title)
    {
        global $dbM;

        $dbM = $this->connect();
        // 1. define the query
        $sql = "SELECT * FROM bucket WHERE title = :title";
        // 2. prepare the statement
        $statement = $dbM->prepare($sql);
        // 3. bind parameters
        $statement->bindParam(':title', $title, PDO::PARAM_STR);
        // 4. execute the statement
        $statement->execute();
        // 5. return the result
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        $milestoneID = row[0];
        return $milestoneID;
    }

    function getMilestones()
    {   // get all the milestone rows (the entire bucket if you will
        global $dbM;

        $dbM = $this->connect();
        // 1. define the query
        $sql = "SELECT * FROM bucket ORDER BY id";

        // 2. prepare the statement
        $statement = $dbM->prepare($sql);

        // 3. bind parameters

        // 4. execute the statement
        $statement->execute();

        // 5. return the result
        $bucket = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $bucket;
    }

    function insertMS()
    {
        //insert a new milestone
        /*
         *
         * INSERT INTO bucket(title, priority, pocName, streetAddress, city, province,
         *                    postalCode, cost, timeTravel, timeVisit, day, month, year,
         *                    image, ongoing)
         *             VALUES('Meet Grandson', '9', 'Sara', '715 Main Street', 'Philadelphia', 'PA',
         *                    '19086', '1125', '2', '7', '1', '9', '2019', 'mt.jpeg', 0);
         */
        global $dbM;
        global $_SESSION;

        $dbM = $this->connect();
        // 0. get data from $_SESSION[]. If I ever wanted to test my getters(), how about now!
        $title = $_SESSION['ms']->getTitle();
        $priority = $_SESSION['ms']->getPriority();
        $pocName = $_SESSION['ms']->getLocation()->getPOCName();
        $streetAddress = $_SESSION['ms']->getLocation()->getStreetAddress();
        $city = $_SESSION['ms']->getLocation()->getCity();
        $province = $_SESSION['ms']->getLocation()->getProvince();
        $postalCode= $_SESSION['ms']->getLocation()->getPostalCode();
        $cost= $_SESSION['ms']->getInvestment()->getCost();
        $timeTravel = $_SESSION['ms']->getInvestment()->getTimeTravel();
        $timeVisit = $_SESSION['ms']->getInvestment()->getTimeVisit();
        $day = $_SESSION['ms']->getOccurence()->getDay();
        $month = $_SESSION['ms']->getOccurence()->getMonth();
        $year = $_SESSION['ms']->getOccurence()->getYear();
        $image = $_SESSION['ms']->getImage();
        $ongoing = $_SESSION['ms']->getOngoing();

        // 1. define the query

        $sql = "INSERT INTO bucket(`title`, `priority`, `pocName`, `streetAddress`, `city`, `province`, `postalCode`, `cost`, `timeTravel`, `timeVisit`,`day`, `month`, `year`,`image`, `ongoing`)
            VALUES (:title, :priority, :pocName, :streetAddress, :city, :province, :postalCode, :cost, :timeTravel, :timeVisit, :day, :month, :year, :image, :ongoing)";

        // 2. prepare the statement
        $statement = $dbM->prepare($sql);

        //3. bind parameters

        $statement->bindParam(':title', $title, PDO::PARAM_STR);
        $statement->bindParam(':priority', $priority, PDO::PARAM_INT);
        $statement->bindParam(':pocName', $pocName, PDO::PARAM_STR);
        $statement->bindParam(':streetAddress', $streetAddress, PDO::PARAM_STR);
        $statement->bindParam(':city', $city, PDO::PARAM_STR);
        $statement->bindParam(':province', $province, PDO::PARAM_STR);
        $statement->bindParam(':postalCode', $postalCode, PDO::PARAM_INT);
        $statement->bindParam(':cost', $cost, PDO::PARAM_INT);
        $statement->bindParam(':timeTravel', $timeTravel, PDO::PARAM_INT);
        $statement->bindParam(':timeVisit', $timeVisit, PDO::PARAM_INT);
        $statement->bindParam(':day', $day, PDO::PARAM_INT);
        $statement->bindParam(':month', $month, PDO::PARAM_INT);
        $statement->bindParam(':year', $year, PDO::PARAM_INT);
        $statement->bindParam(':image', $image, PDO::PARAM_STR);
        $statement->bindParam(':ongoing', $ongoing, PDO::PARAM_INT);
        // 4. execute the statement
        $result = $statement->execute();

        // 5. return the result
        return $result;

    }

    function getMilestone($id)
    {
        global $dbM;
        $dbM = $this->connect();

        // 1. define the query
        $sql = "SELECT * FROM bucket WHERE id = :id";

        // 2. prepare the statement
        $statement = $dbM->prepare($sql);

        // 3. bind parameters
        $statement->bindParam(':id', $id, PDO::PARAM_INT);

        // 4. execute the statement
        $statement->execute();

        // 5. return the result
        $row = $statement->fetch(PDO::FETCH_ASSOC);

        //check if this is an OngoingMilestone
        /*
        if ($row['ongoing'] == 1) {
            //my efforts here fail
            $pros = array();
            $cons = array();
            return new OngoingMilestone($row['title'], $row['priority'], $row['pocName'],
                $row['streetAddress'], $row['city'], $row['province'], $row['postalCode'],
                $row['cost'], $row['timeTravel'], $row['timeVisit'], $row['day'],
                $row['month'], $row['year'], "");
        }
        else
        {
            return new Milestone($result['fname'], $result['lname'], $result['age'],
                              $result['gender'], $result['phone'], $result['email'], $result['state'],
                              $result['seeking'], $result['bio']);
        }
        */
        return $row;
    }

    function close()
    {
        global $dbM;
        $dbM = null;
    }
}