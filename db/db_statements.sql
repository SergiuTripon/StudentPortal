DROP TABLE paypal_log; 
DROP TABLE user_details; 
DROP TABLE user_fees; 
DROP TABLE user_token; 
DROP TABLE user_tasks;
DROP TABLE system_lectures;
DROP TABLE system_tutorials;
DROP TABLE system_modules;
DROP TABLE user_timetable;
DROP TABLE system_exams;
DROP TABLE system_events;
DROP TABLE booked_events;
DROP TABLE user_signin; 

CREATE TABLE `student_portal`.`user_signin` (
	`userid` INT(11) NOT NULL AUTO_INCREMENT UNIQUE PRIMARY KEY,
	`account_type` VARCHAR(8) NOT NULL,
	`email` VARCHAR(300) NOT NULL UNIQUE,
	`password` CHAR(70) NOT NULL UNIQUE,
	`created_on` DATETIME NOT NULL,
	`updated_on` DATETIME
) ENGINE = InnoDB;

CREATE TABLE `student_portal`.`user_token` (
	`userid` INT(11) NOT NULL AUTO_INCREMENT UNIQUE,
	`token` CHAR(70) UNIQUE,
	`created_on` DATETIME,
FOREIGN KEY (userid)    
REFERENCES user_signin(userid)   
ON UPDATE CASCADE   
ON DELETE CASCADE   
) ENGINE = InnoDB; 

CREATE TABLE `student_portal`.`user_details` (
	`userid` INT(11) NOT NULL AUTO_INCREMENT UNIQUE,
	`firstname` VARCHAR(70) NOT NULL,
	`surname` VARCHAR(70) NOT NULL,
	`gender` VARCHAR(6) NOT NULL,
	`nationality` VARCHAR(70),
	`studentno` INT(9) NOT NULL UNIQUE,
	`degree` VARCHAR(70),
	`dateofbirth` DATE,
	`phonenumber` VARCHAR(70),
	`address1` VARCHAR(70),
	`address2` VARCHAR(70),
	`town` VARCHAR(70),
	`city` VARCHAR(70),
	`country` VARCHAR(70),
	`postcode` VARCHAR(70),
	`created_on` DATETIME NOT NULL,
	`updated_on` DATETIME,
FOREIGN KEY (userid)    
REFERENCES user_signin(userid)   
ON UPDATE CASCADE   
ON DELETE CASCADE   
) ENGINE = InnoDB;  


CREATE TABLE `student_portal`.`user_fees` (
	`userid` INT(11) NOT NULL AUTO_INCREMENT UNIQUE,
	`fee_amount` NUMERIC(15,2) NOT NULL,
	`isHalf` TINYINT(1) NOT NULL,
	`created_on` DATETIME NOT NULL,
	`updated_on` DATETIME,
FOREIGN KEY (userid)    
REFERENCES user_signin(userid)   
ON UPDATE CASCADE   
ON DELETE CASCADE   
) ENGINE = InnoDB;   

CREATE TABLE `student_portal`.`paypal_log` (
	`userid` INT(11) NOT NULL,
	`payment_id` INT(11) NOT NULL AUTO_INCREMENT UNIQUE,
	`invoice_id` BIGINT(10) NOT NULL,
	`transaction_id` VARCHAR(17) NOT NULL,
	`product_id` INT(1) NOT NULL,
	`product_name` VARCHAR(70) NOT NULL,
	`product_quantity` INT(11) NOT NULL,
	`product_amount` NUMERIC(15,2) NOT NULL,
	`payer_firstname` VARCHAR(70) NOT NULL,
	`payer_surname` VARCHAR(70) NOT NULL,
	`payer_email` VARCHAR(300) NOT NULL,
	`payer_phonenumber` VARCHAR(70),
	`payer_address1` VARCHAR(70) NOT NULL,
	`payer_address2` VARCHAR(70),
	`payer_town` VARCHAR(70),
	`payer_city` VARCHAR(70) NOT NULL,
	`payer_country` VARCHAR(70),
	`payer_postcode` VARCHAR(70) NOT NULL,
	`payment_type` VARCHAR(5) NOT NULL,
	`payment_status` VARCHAR(9) NOT NULL,
	`created_on` DATETIME NOT NULL,
	`updated_on` DATETIME,
	`completed_on` DATETIME,
	`cancelled_on` DATETIME,
FOREIGN KEY (userid)    
REFERENCES user_signin(userid)   
ON UPDATE CASCADE   
ON DELETE CASCADE   
) ENGINE = InnoDB;

CREATE TABLE `student_portal`.`user_tasks` (
	`userid` INT(11) NOT NULL,
	`taskid` INT(11) NOT NULL AUTO_INCREMENT UNIQUE,
	`task_name` VARCHAR(70) NOT NULL,
	`task_notes` VARCHAR(5000),
	`task_url` VARCHAR(300),
	`task_class` VARCHAR(15) NOT NULL,
	`task_startdate` DATETIME NOT NULL,
	`task_duedate` DATETIME NOT NULL,
	`task_category` VARCHAR(10) NOT NULL,
	`task_status` VARCHAR(10) NOT NULL,
	`created_on` DATETIME NOT NULL,
	`updated_on` DATETIME,
	`completed_on` DATETIME,
FOREIGN KEY (userid)    
REFERENCES user_signin(userid)   
ON UPDATE CASCADE   
ON DELETE CASCADE   
) ENGINE = InnoDB;

CREATE TABLE `student_portal`.`system_modules` (
	`moduleid` INT(11) NOT NULL AUTO_INCREMENT UNIQUE PRIMARY KEY,
	`module_name` VARCHAR(300) NOT NULL,
	`module_notes` VARCHAR(5000),
	`module_url` VARCHAR(70),
	`module_status` VARCHAR(10) NOT NULL,
	`created_on` DATETIME NOT NULL,
	`updated_on` DATETIME
) ENGINE = InnoDB;

CREATE TABLE `student_portal`.`system_lectures` (
	`moduleid` INT(11) NOT NULL,
	`lectureid` INT(11) NOT NULL AUTO_INCREMENT UNIQUE,
	`lecture_name` VARCHAR(300) NOT NULL,
	`lecture_notes` VARCHAR(5000),
	`lecture_day` VARCHAR(9) NOT NULL,
	`lecture_from_time` TIME NOT NULL,
	`lecture_to_time` TIME NOT NULL,
	`lecture_from_date` DATE NOT NULL,
	`lecture_to_date` DATE NOT NULL,
	`lecture_location` VARCHAR(300) NOT NULL,
	`lecture_capacity` INT(11) NOT NULL,
	`lecture_status` VARCHAR(9) NOT NULL,
	`created_on` DATETIME NOT NULL,
	`updated_on` DATETIME,
FOREIGN KEY (moduleid)
REFERENCES system_modules(moduleid)
ON UPDATE CASCADE
ON DELETE CASCADE
) ENGINE = InnoDB;

CREATE TABLE `student_portal`.`system_tutorials` (
	`moduleid` INT(11) NOT NULL,
	`tutorialid` INT(11) NOT NULL AUTO_INCREMENT UNIQUE,
	`tutorial_name` VARCHAR(300) NOT NULL,
	`tutorial_notes` VARCHAR(5000),
	`tutorial_day` VARCHAR(9) NOT NULL,
	`tutorial_from_time` TIME NOT NULL,
	`tutorial_to_time` TIME NOT NULL,
	`tutorial_from_date` DATE NOT NULL,
	`tutorial_to_date` DATE NOT NULL,
	`tutorial_location` VARCHAR(300) NOT NULL,
	`tutorial_capacity` VARCHAR(11) NOT NULL,
	`tutorial_status` VARCHAR(9) NOT NULL,
	`created_on` DATETIME NOT NULL,
	`updated_on` DATETIME,
FOREIGN KEY (moduleid)
REFERENCES system_modules(moduleid)
ON UPDATE CASCADE
ON DELETE CASCADE
) ENGINE = InnoDB;

CREATE TABLE `student_portal`.`system_exams` (
	`examid` INT(11) NOT NULL AUTO_INCREMENT UNIQUE PRIMARY KEY,
	`exam_name` VARCHAR(300) NOT NULL,
	`exam_notes` VARCHAR(5000),
	`exam _date` DATETIME NOT NULL,
	`exam_time` TIME NOT NULL,
	`exam_location` VARCHAR(300) NOT NULL,
	`exam_capacity` INT(11) NOT NULL,
	`exam_status` VARCHAR(9) NOT NULL,
	`created_on` DATETIME NOT NULL,
	`updated_on` DATETIME
) ENGINE = InnoDB;

CREATE TABLE `student_portal`.`user_timetable` (
	`userid` INT(11) NOT NULL,
	`moduleid` INT(11) NOT NULL,
FOREIGN KEY (userid)
REFERENCES user_signin(userid),
FOREIGN KEY (moduleid)
REFERENCES system_modules(moduleid)
ON UPDATE CASCADE
ON DELETE CASCADE
) ENGINE = InnoDB;

CREATE TABLE `student_portal`.`system_events` (
	`eventid` INT(11) NOT NULL AUTO_INCREMENT UNIQUE PRIMARY KEY,
	`event_name` VARCHAR(70) NOT NULL,
	`event_notes` VARCHAR(5000),
	`event_url` VARCHAR(70),
	`event_class` VARCHAR(15) NOT NULL,
	`event_from` DATETIME NOT NULL,
	`event_to` DATETIME NOT NULL,
	`event_amount` NUMERIC(15,2) NOT NULL,
	`event_ticket_no` INT(11) NOT NULL,
	`event_category` VARCHAR(10) NOT NULL,
	`event_status` VARCHAR(10) NOT NULL,
	`created_on` DATETIME NOT NULL,
	`updated_on` DATETIME
) ENGINE = InnoDB;

CREATE TABLE `student_portal`.`booked_events` (
	`userid` INT(11) NOT NULL,
	`eventid` INT(11) NOT NULL,
	`event_name` VARCHAR(300) NOT NULL,
	`event_amount` NUMERIC(15,2) NOT NULL,
	`tickets_quantity` VARCHAR(11) NOT NULL,
	`booked_on` DATETIME NOT NULL,
FOREIGN KEY (userid)
REFERENCES user_signin(userid),
FOREIGN KEY (eventid)
REFERENCES system_events(eventid)
ON UPDATE CASCADE
ON DELETE CASCADE
) ENGINE = InnoDB;

#Events dummy data
INSERT INTO `system_events`(`eventid`, `event_name`, `event_notes`, `event_url`, `event_class`, `event_from`, `event_to`, `event_amount`, `event_ticket_no`, `event_category`, `event_status`, `created_on`, `updated_on`) VALUES (1,'City Careers','','','event-important','2015-03-02 16:00:00','2015-03-02 19:00:00','10.00','50','Careers','active','0000-00-00 0000:00:00','');



#Timetable dummy data
INSERT INTO `system_modules`(`moduleid`, `module_name`, `module_notes`, `module_url`, `module_status`, `created_on`, `updated_on`) VALUES ('1','Theory of Computation','','','active','0000-00-00 00:00:00','');
INSERT INTO `system_lectures`(`moduleid`,`lectureid`, `lecture_name`, `lecture_notes`, `lecture_day`, `lecture_from_time`, `lecture_to_time`, `lecture_from_date`, `lecture_to_date`, `lecture_location`, `lecture_capacity`, `lecture_status`, `created_on`, `updated_on`) VALUES ('1','1','Theory of Computation - Lecture', '','Monday','15:00:00', '17:00:00', '2015-02-01','2015-03-01','Great Hall', '150','active','0000-00-00 00:00:00','');
INSERT INTO `system_tutorials`(`moduleid`, `tutorialid`, `tutorial_name`, `tutorial_notes`, `tutorial_day`, `tutorial_from_time`, `tutorial_to_time`, `tutorial_from_date`, `tutorial_to_date`, `tutorial_location`, `tutorial_capacity`, `tutorial_status`, `created_on`, `updated_on`) VALUES ('1','1','Theory of Computation - Tutorial','','Tuesday','11:00:00','13:00:00','2015-02-01','2015-03-01', 'EG12', '30','active','0000-00-00 0000:00:00','');
INSERT INTO `system_exams`(`examid`, `exam_name`, `exam_notes`, `exam _date`, `exam_time`, `exam_location`, `exam_capacity`, `exam_status`, `created_on`, `updated_on`) VALUES ('1','Theory of Computation - Exam','','2015-03-01','14:00:00','The Crypt','40','active','0000-00-00 00:00:00', '');
INSERT INTO `user_timetable`(`userid`, `moduleid`) VALUES (2,1);

SELECT system_lectures.lecture_name, system_tutorials.tutorial_name FROM user_timetable
LEFT JOIN system_modules ON user_timetable.moduleid=system_modules.moduleid
LEFT JOIN system_lectures ON user_timetable.moduleid=system_lectures.moduleid
LEFT JOIN system_tutorials ON user_timetable.moduleid=system_tutorials.moduleid
WHERE user_timetable.userid = 1 AND system_lectures.lecture_day = 'Monday' AND system_tutorials.tutorial_day <> 'Tuesday';

#User dummy data
INSERT INTO `user_signin`(`userid`, `account_type`, `email`, `password`, `created_on`) VALUES ('1', 'admin', 'admin@student-portal.co.uk', '$2y$10$2UOneiOEmmi6kI4DG0di4u2/8oOsdpYDRsc8XzoM2.nKx3ZErPjEe', '0000-00-00 00:00:00');
INSERT INTO `user_fees`(`userid`, `fee_amount`, `created_on`) VALUES ('1', '0.00', '0000-00-00 00:00:00');
INSERT INTO `user_details`(`userid`, `studentno`, `firstname`, `surname`, `gender`, `dateofbirth`, `phonenumber`, `degree`, `address1`, `address2`, `town`, `city`, `country`, `postcode`, `created_on`) VALUES ('1','1','Admin','strator', 'male', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00');
INSERT INTO `user_token`(`userid`, `token`, `created_on`) VALUES ('1', NULL, '0000-00-00 00:00:00');