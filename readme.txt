Submitted for: Professor Ostrander
In Consideration of: IT 328 Final Project
                                 Green River Community College 
Quoted from the assignment:
"Include a readme.txt file in your GitHub repo, that specifically describes how 
 you implemented each of the Project Requirements"

Eight Project Requirements:
(1.)Separates all database/business logic using the MVC pattern.
      The folder structure for https://bturnerg.greenriverdev.com/328/Final_Project reflects my attempt to 
      address (1). There are seperate folders for model, view, and controller. For my Bucket app, I did
      not see a clear "fit" for the controler

(2.) Routes all URLs and leverages a templating language using the Fat-Free framework
           All URLS are routed, there are:
                                               default : 'GET /'
                                                 debug: 'GET|POST /debug'
                     display bucket contents: 'GET /view'
      display 1 milestone using an ID#: 'GET /displayOne/@milestone_id'
      display & process the POC form: 'GET|POST /form_1'
display the contact information form: 'GET|POST /form_2'
           display an OngoingMilestone: '/ongoingMS/@nextMS_id'

(3.) Has a clearly defined database layer using PDO and prepared statements
      All database access is thru PDOs, and in a single file: model/milestoneDB.php
      
(4.) Data can be viewed, added, updated, and deleted.
      Not Yet: Data can be viewed, and added. As of Monday, June 10th the only active (supported) functions
      are "View" and "Add Milestone"
(5.) Has a history of commits from both team members to a Git repositor
       the Git repo reflects continuous commits by all members (just me, actually)

(6.) Uses OOP, and defines multiple classes, including at least one inheritance relationship.
      The app depends on OngoingMilestone (inheritance from Milestone), embedded within each
       Milestone are three attributes Location, Occurance, and Investment

(7.) Contains full Docblocks for all PHP files and follows PEAR standards.
      Not really. The five classes are documented well: milestone, ongoingMilestone, location, investment, and occurance

(8.) Has full validation on the client side through JavaScript and server side through PHP.
      NO. I have been frustrated, and it has held me back trying to validate as I developed, so this
      is not realized yet.

