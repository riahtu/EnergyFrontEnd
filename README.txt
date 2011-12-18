UW Energy Front End v1.2
Author: Xin Tang (xtang@cs.wisc.edu)
2011/12/14

README

1. Project Description
This project is the front end of the UW-Madison Energy Monitoring System. 
It uses website format to displays energy consumption related data such 
electricity usage and room temperature which our research group collect 
on UW campus.

2. Versions
v1.2 - Corrected energy consumption sum and unit. Changed the names to 
abbreviations at the summary box electricity pie chart. Added dummy input 
file (mysql_db_inputs.txt). Merged title and global_navigation div.

v1.1 - Optimized db tables (see 3.b) and updated db interface.

v1.0 - In this version we implemented an interface for user to look up electricity 
usages and room temperature in buildings, departments or services.
Besides the data line chart, simple statistics such as sum, avg, max 
and min are provided.

3. Installation 
a) required packages
** Apache 2.2 or higher
** php 5.3 or higher
** MySQL 5.5 or higher

b) Database setup
We need to set up the following tables in MySQL for the webpages to fetch data.

 CREATE TABLE `raw_data` (
   `id` int(11) NOT NULL,
   `time` int(11) NOT NULL,
   `value` double NOT NULL,
   PRIMARY KEY (`id`,`time`)
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

 CREATE TABLE `aggr_data_1min` (
   `id` int(11) NOT NULL,
   `time` int(11) NOT NULL,
   `value` double NOT NULL,
   PRIMARY KEY (`id`,`time`)
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

 CREATE TABLE `aggr_data_1hour` (
   `id` int(11) NOT NULL,
   `time` int(11) NOT NULL,
   `value` double NOT NULL,
   PRIMARY KEY (`id`,`time`)
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

 CREATE TABLE `aggr_data_1day` (
   `id` int(11) NOT NULL,
   `time` int(11) NOT NULL,
   `value` double NOT NULL,
   PRIMARY KEY (`id`,`time`)
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

 CREATE TABLE `buildings` (
   `id` int(11) NOT NULL,
   `name` varchar(40) NOT NULL,
   `address` varchar(40) NOT NULL,
   PRIMARY KEY (`id`)
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

 CREATE TABLE `departments` (
   `id` int(11) NOT NULL,
   `name` varchar(40) NOT NULL,
   `address` varchar(40) NOT NULL,
   PRIMARY KEY (`id`)
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

 CREATE TABLE `services` (
   `id` int(11) NOT NULL,
   `name` varchar(40) NOT NULL,
   `address` varchar(40) NOT NULL,
   PRIMARY KEY (`id`)
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8; 

 CREATE TABLE `sensors` (
   `id` int(11) NOT NULL,
   `name` varchar(40) NOT NULL,
   `address` varchar(40) NOT NULL,
   `data_unit` varchar(15) NOT NULL,
   `data_type` varchar(4) NOT NULL,
   PRIMARY KEY (`id`)
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8;


 CREATE TABLE `relations` (
   `parent_id` int(11) NOT NULL,
   `child_id` int(11) NOT NULL,
   PRIMARY KEY (`parent_id`,`child_id`),
   KEY `parent_id` (`parent_id`),
   KEY `child_id` (`child_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

* Abbreviations of names are used to display some charts. To display them  
properly, words in the 'name' attributes should be separated by single space  
and do not begin or end with space. 

c) Data Update
we need to setup some daemons or cron jobs to update all the data tables. 
These codes are not included in this project.

d) Database Login Info
Edit /php/dbLogin to provide db log in information.

e) Dummy Data
File "mysql_db_inputs.txt" in folder "tests" can be used to generate dummy 
data for testing.

4. Potential bugs / Improvements
v1.2
* data search dropdown menu: the page goes back to the top when the dropdown 
  menu is clicked.
* data search dropdown menu: contents do not update based on user's choices. 
  (ie. reset the service dropdown once user choose a building.)
* data sum: use user's choice of end time instead of the end time in the db. 
  It leads to a bigger value. (sum=avg*time)
* navigation: redesign the navigation bar..

5. Credits
* Many thanks to my partner Igor Canadi who gave me a lot of useful feedback 
to make this front end better.