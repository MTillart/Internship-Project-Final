*** Tracking Script & Admin***

* Description

This is a tracking tool that tracks:
	* the time user went on a page
	* which page the user is on
	* where the user went next
	* how long the user was on the page

Also scripts for admin panel, where a webpage administrator can see all the data collected
and filter it. 

Files for tracking tool:
 	JS/main.js
	* main script for tracking user and sending the data to main.php
	* all the trackable link on the site need to be on A-element 

	main.php
	* Is for receiving data from main.js and saving it to database.
	* Requirs conf.php file to connect with database.
	* The INSET INTO query is fit for tracking table (MySQL code below)

	db/conf.php
	* confidental information for connecting database.
	* CHANGE! For your server and user details.
	

Table structure for table `tracking`

CREATE TABLE `tracking` (
  `id` int(10) NOT NULL,
  `FromWhere` varchar(255) NOT NULL,
  `ToWhere` varchar(255) NOT NULL,
  `TheTime` varchar(255) NOT NULL,
  `Duration` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

Files for admin panel:
	login_system/admin.php
	* A webpage where the admin can see the tracking data.
	* The user can acces the webpage AFTER she/he has logged in.
	* connects with api/getdata.php to get all the information from the database
	* Also need vue.js file that is in JS folder, but can be downloaded online. 

	login_system/login.php && logout.php && register.php
	* For user registering, logging in and logging out.
	* Require conf.php file

	api/getdata.php
	* Includes all the command sent to database. If you want to add filters for admin panel you can add the mysql SELECT commands in this getdata.php file.
	* requirs conf.php file
