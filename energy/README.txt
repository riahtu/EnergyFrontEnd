UW Energy Front End v1.0
Author: Xin Tang (xtang@cs.wisc.edu)

README

1. Project Description
This project is the front end of the UW-Madison Energy Monitoring System. 
It use website format to displays energy consumption related data such 
electricity usage and room temperature which we collect on UW campus.

2. Version
v1.0
In this version we implement an interface for user to look up electricity 
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

CREATE TABLE buildings(
id int not null,
name varchar(30) not null,
address varchar(30) not null,
primary key(id)
);

CREATE TABLE departments(
id int not null,
name varchar(30) not null,
address varchar(30) not null,
primary key(id)
);

CREATE TABLE services(
id int not null,
name varchar(30) not null,
address varchar(30) not null,
primary key(id)
);

CREATE TABLE sensors(
id int not null,
name varchar(30) not null,
address varchar(30) not null,
data_unit varchar(15) not null,
data_type varchar(4) not null,
primary key(id)
);

CREATE TABLE relations(
parent_id int not null,
child_id int not null,
primary key(parent_id, child_id)
);



CREATE table raw_data(
id int not null,
time int not null,
value int not null,
primary key(id, time)
);


CREATE table aggr_data_1min(
id int not null,
time int not null,
value int not null,
primary key(id, time)
);

CREATE table aggr_data_1hour(
id int not null,
time int not null,
value int not null,
primary key(id, time)
);



CREATE table aggr_data_1day(
id int not null,
time int not null,
value int not null,
primary key(id, time)
);

* table relations describe relations between buildings, departments, services 
and sensors.
* table data_master describe relationship between the object and the data.

c) Data Update
we need to setup some daemons to update corresponding services, 
departments, and buildings once we get new sensor data. This code is not
included in this project.

d) Database Login Info
Edit /php/dbLogin to provide db log in information.