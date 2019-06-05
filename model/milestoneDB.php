<?php
/**
 * Bruce Turner, Professor Ostrander, Spring 2019
 * IT 328 Full Stack Web Development
 * Bucket app handling the "milestones" in the DB:
 * file: milestoneDB.php
 * date: Tuesday, June 4 2019
 * class Milestone
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

    function insertMember($fname, $lname, $age, $gender, $phone, $email, $state,
                          $seeking, $bio, $premium, $image)
    {
        global $dbM;

        $dbM = $this->connect();
        // 1. define the query

        $sql = "INSERT INTO bucket(`fname`, `lname`, `age`, `gender`, `phone`, `email`, `state`, `seeking`, `bio`, `premium`, `image`)
            VALUES (:fname, :lname, :age, :gender, :phone, :email, :state, :seeking, :bio, :premium, :image)";

        // 2. prepare the statement
        $statement = $dbM->prepare($sql);

        //3. bind parameters
        $statement->bindParam(':fname', $fname, PDO::PARAM_STR);
        $statement->bindParam(':lname', $lname, PDO::PARAM_STR);
        $statement->bindParam(':age', $age, PDO::PARAM_INT);
        $statement->bindParam(':gender', $gender, PDO::PARAM_STR);
        $statement->bindParam(':phone', $phone, PDO::PARAM_STR);
        $statement->bindParam(':email', $email, PDO::PARAM_STR);
        $statement->bindParam(':state', $state, PDO::PARAM_STR);
        $statement->bindParam(':seeking', $seeking, PDO::PARAM_STR);
        $statement->bindParam(':bio', $bio, PDO::PARAM_STR);
        $statement->bindParam(':premium', $premium, PDO::PARAM_INT);
        $statement->bindParam(':image', $image, PDO::PARAM_STR);

        // 4. execute the statement
        $success = $statement->execute();

        // 5. return the result
        return $success;

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

        //check if this is a premium member
        /*
        if ($result['ongoing'] == 1) {
            //my efforts here fail
            return new PremiumMember($result['fname'], $result['lname'], $result['age'],
                $result['gender'], $result['phone'], $result['email'], $result['state'],
                $result['seeking'], $result['bio'], "");
        }
        else
        {
            return new Member($result['fname'], $result['lname'], $result['age'],
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