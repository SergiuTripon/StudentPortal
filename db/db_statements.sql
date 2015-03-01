DROP TABLE system_map_markers;
DROP TABLE cycle_hire_status_now;
DROP TABLE tube_station_status_this_weekend;
DROP TABLE tube_line_status_this_weekend;
DROP TABLE tube_station_status_now;
DROP TABLE tube_line_status_now;
DROP TABLE user_feedback_lookup;
DROP TABLE user_feedback;
DROP TABLE system_lectures;
DROP TABLE system_tutorials;
DROP TABLE system_exams;
DROP TABLE user_timetable;
DROP TABLE system_modules;
DROP TABLE reserved_books;
DROP TABLE system_books;
DROP TABLE user_tasks;
DROP TABLE booked_events;
DROP TABLE system_events;
DROP TABLE user_messages_lookup;
DROP TABLE user_messages;
DROP TABLE paypal_log;
DROP TABLE user_fees; 
DROP TABLE user_token;
DROP TABLE user_details;
DROP TABLE user_signin;

#Sign In
CREATE TABLE `user_signin` (
  `userid` INT(11) NOT NULL AUTO_INCREMENT UNIQUE PRIMARY KEY,
  `account_type` VARCHAR(8) NOT NULL,
  `email` VARCHAR(300) NOT NULL UNIQUE,
  `password` CHAR(70) NOT NULL UNIQUE,
  `isSignedIn` TINYINT(1) NOT NULL,
  `created_on` DATETIME NOT NULL,
  `updated_on` DATETIME
) ENGINE = InnoDB;

#User details
CREATE TABLE `user_details` (
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

#Forgotten Password & Password Reset
CREATE TABLE `user_token` (
  `userid` INT(11) NOT NULL AUTO_INCREMENT UNIQUE,
  `token` CHAR(70) UNIQUE,
  `created_on` DATETIME,
FOREIGN KEY (userid)
REFERENCES user_signin(userid)
ON UPDATE CASCADE
ON DELETE CASCADE
) ENGINE = InnoDB;

#Fees
CREATE TABLE `user_fees` (
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

#Paypal payment
CREATE TABLE `paypal_log` (
	`userid` INT(11) NOT NULL,
	`payment_id` INT(11) NOT NULL AUTO_INCREMENT UNIQUE PRIMARY KEY,
	`invoice_id` BIGINT(10) NOT NULL UNIQUE,
	`transaction_id` VARCHAR(17) NOT NULL UNIQUE,
	`product_id` INT(1) NOT NULL UNIQUE,
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
	`payer_country` VARCHAR(70) NOT NULL,
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

#Messenger
CREATE TABLE `user_messages` (
	`messageid` INT(11) NOT NULL AUTO_INCREMENT UNIQUE PRIMARY KEY,
	`message_subject` VARCHAR(300) NOT NULL,
	`message_body` VARCHAR(5000),
	`created_on` DATETIME NOT NULL
) ENGINE = InnoDB;

#Messenger
CREATE TABLE `user_messages_lookup` (
  `messageid` INT(11) NOT NULL AUTO_INCREMENT,
  `message_from` INT(11) NOT NULL,
  `message_to` INT(11) NOT NULL,
  `isRead` TINYINT(1) NOT NULL,
FOREIGN KEY (messageid)
REFERENCES user_messages(messageid),
FOREIGN KEY (message_from)
REFERENCES user_signin(userid),
FOREIGN KEY (message_to)
REFERENCES user_signin(userid)
ON UPDATE CASCADE
ON DELETE CASCADE
) ENGINE = InnoDB;

#Events
CREATE TABLE `system_events` (
	`eventid` INT(11) NOT NULL AUTO_INCREMENT UNIQUE PRIMARY KEY,
	`event_name` VARCHAR(300) NOT NULL,
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

#Events
CREATE TABLE `booked_events` (
  `userid` INT(11) NOT NULL,
  `eventid` INT(11) NOT NULL,
	`event_amount_paid` NUMERIC(15,2) NOT NULL,
	`ticket_quantity` INT(11) NOT NULL,
	`booked_on` DATETIME NOT NULL,
FOREIGN KEY (userid)
REFERENCES user_signin(userid),
FOREIGN KEY (eventid)
REFERENCES system_events(eventid)
ON UPDATE CASCADE
ON DELETE CASCADE
) ENGINE = InnoDB;

#Library
CREATE TABLE `system_books` (
	`bookid` INT(11) NOT NULL AUTO_INCREMENT UNIQUE PRIMARY KEY,
	`book_name` VARCHAR(300) NOT NULL,
	`book_author` VARCHAR(300) NOT NULL,
	`book_notes` VARCHAR(5000),
	`book_copy_no` INT(11) NOT NULL,
	`book_status` VARCHAR(9) NOT NULL,
	`created_on` DATETIME NOT NULL,
	`updated_on` DATETIME
) ENGINE = InnoDB;

#Library
CREATE TABLE `reserved_books` (
  `userid` INT(11) NOT NULL,
	`bookid` INT(11) NOT NULL,
	`book_class` VARCHAR(15) NOT NULL,
	`reserved_on` DATE NOT NULL,
	`toreturn_on` DATE NOT NULL,
  `returned_on` DATE NOT NULL,
	`isReturned` TINYINT(1) NOT NULL,
FOREIGN KEY (userid)
REFERENCES user_signin(userid),
FOREIGN KEY (bookid)
REFERENCES system_books(bookid)
ON UPDATE CASCADE
ON DELETE CASCADE
) ENGINE = InnoDB;

#Calendar
CREATE TABLE `user_tasks` (
	`userid` INT(11) NOT NULL,
	`taskid` INT(11) NOT NULL AUTO_INCREMENT UNIQUE PRIMARY KEY,
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

#Timetable
CREATE TABLE `system_modules` (
	`moduleid` INT(11) NOT NULL AUTO_INCREMENT UNIQUE PRIMARY KEY,
	`module_name` VARCHAR(300) NOT NULL,
	`module_notes` VARCHAR(5000),
	`module_url` VARCHAR(70),
	`module_status` VARCHAR(10) NOT NULL,
	`created_on` DATETIME NOT NULL,
	`updated_on` DATETIME
) ENGINE = InnoDB;

#Timetable
CREATE TABLE `user_timetable` (
	`userid` INT(11) NOT NULL,
	`moduleid` INT(11) NOT NULL,
FOREIGN KEY (userid)
REFERENCES user_signin(userid),
FOREIGN KEY (moduleid)
REFERENCES system_modules(moduleid)
ON UPDATE CASCADE
ON DELETE CASCADE
) ENGINE = InnoDB;

#Timetable
CREATE TABLE `system_lectures` (
	`moduleid` INT(11) NOT NULL UNIQUE,
	`lectureid` INT(11) NOT NULL AUTO_INCREMENT UNIQUE PRIMARY KEY,
	`lecture_name` VARCHAR(300) NOT NULL,
	`lecture_lecturer` INT(11) NOT NULL,
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

#Timetable
CREATE TABLE `system_tutorials` (
	`moduleid` INT(11) NOT NULL UNIQUE,
	`tutorialid` INT(11) NOT NULL AUTO_INCREMENT UNIQUE PRIMARY KEY,
	`tutorial_name` VARCHAR(300) NOT NULL,
	`tutorial_assistant` INT(11) NOT NULL,
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

#Timetable
CREATE TABLE `system_exams` (
	`moduleid` INT(11) NOT NULL UNIQUE,
	`examid` INT(11) NOT NULL AUTO_INCREMENT UNIQUE PRIMARY KEY,
	`exam_name` VARCHAR(300) NOT NULL,
	`exam_notes` VARCHAR(5000),
	`exam_date` DATE NOT NULL,
	`exam_time` TIME NOT NULL,
	`exam_location` VARCHAR(300) NOT NULL,
	`exam_capacity` INT(11) NOT NULL,
	`exam_status` VARCHAR(9) NOT NULL,
	`created_on` DATETIME NOT NULL,
	`updated_on` DATETIME,
FOREIGN KEY (moduleid)
REFERENCES system_modules(moduleid)
ON UPDATE CASCADE
ON DELETE CASCADE
) ENGINE = InnoDB;

#Feedback
CREATE TABLE `user_feedback` (
  `feedbackid` INT(11) NOT NULL AUTO_INCREMENT UNIQUE PRIMARY KEY,
  `feedback_subject` VARCHAR(300) NOT NULL,
  `feedback_body` VARCHAR(5000) NOT NULL,
  `created_on` DATETIME NOT NULL
) ENGINE = InnoDB;

#Feedback
CREATE TABLE `user_feedback_lookup` (
  `feedbackid` INT(11) NOT NULL,
  `feedback_from` INT(11) NOT NULL,
  `moduleid` INT(11) NOT NULL,
  `module_staff` INT(11) NOT NULL,
  `isApproved` TINYINT(1) NOT NULL,
  `isRead` TINYINT(1) NOT NULL,
FOREIGN KEY (feedbackid)
REFERENCES user_feedback(feedbackid),
FOREIGN KEY (feedback_from)
REFERENCES user_signin(userid),
FOREIGN KEY (moduleid)
REFERENCES system_modules(moduleid),
FOREIGN KEY (module_staff)
REFERENCES user_signin(userid)
ON UPDATE CASCADE
ON DELETE CASCADE
) ENGINE = InnoDB;

#Transport
CREATE TABLE `tube_line_status_now` (
  `statusid` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `tube_line` VARCHAR (70) NOT NULL,
  `tube_line_status` VARCHAR (70),
  `tube_line_info` VARCHAR(10000),
  `updated_on` DATETIME NOT NULL
) ENGINE = InnoDB;

#Transport
CREATE TABLE `tube_station_status_now` (
  `statusid` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `tube_station` VARCHAR (70) NOT NULL,
  `tube_station_status` VARCHAR (70),
  `tube_station_info` VARCHAR(10000),
  `updated_on` DATETIME NOT NULL
) ENGINE = InnoDB;

#Transport
CREATE TABLE `tube_line_status_this_weekend` (
  `statusid` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `tube_line` VARCHAR (70) NOT NULL,
  `tube_line_status` VARCHAR (70),
  `tube_line_info` VARCHAR(10000),
  `updated_on` DATETIME NOT NULL
) ENGINE = InnoDB;

#Transport
CREATE TABLE `tube_station_status_this_weekend` (
  `statusid` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `tube_station` VARCHAR (70) NOT NULL,
  `tube_station_status` VARCHAR (70),
  `tube_station_info` VARCHAR(10000),
  `updated_on` DATETIME NOT NULL
) ENGINE = InnoDB;

#Transport
CREATE TABLE `cycle_hire_status_now` (
  `statusid` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `dock_name` VARCHAR (70) NOT NULL,
  `dock_installed` VARCHAR (5),
  `dock_locked` VARCHAR(5),
  `dock_temporary` VARCHAR(5),
  `dock_bikes_available` INT(11),
  `dock_empty_docks` INT(11),
  `dock_total_docks` INT(11),
  `updated_on` DATETIME NOT NULL
) ENGINE = InnoDB;

#University Map
CREATE TABLE `system_map_markers` (
  `markerid` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `marker_title` VARCHAR (70) NOT NULL,
  `marker_description` VARCHAR (5000) NOT NULL,
  `marker_lat` FLOAT(10,6) NOT NULL,
  `marker_long` FLOAT(10,6) NOT NULL,
  `marker_category` VARCHAR (70) NOT NULL
) ENGINE = InnoDB;