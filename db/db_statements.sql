#Feedback
DROP TABLE user_feedback_sent;
DROP TABLE user_feedback_received;
DROP TABLE user_feedback;

#Exams
DROP TABLE user_exam;
DROP TABLE system_exam;

#Results
DROP TABLE user_result;

#Timetable
DROP TABLE user_lecture;
DROP TABLE system_lecture;
DROP TABLE user_tutorial;
DROP TABLE system_tutorial;
DROP TABLE user_module;
DROP TABLE system_module;

#Transport
DROP TABLE cycle_hire_status_now;
DROP TABLE tube_station_status_this_weekend;
DROP TABLE tube_line_status_this_weekend;
DROP TABLE tube_station_status_now;
DROP TABLE tube_line_status_now;

#Library
DROP TABLE system_book_reserved;
DROP TABLE system_book_loaned;
DROP TABLE system_book_requested;
DROP TABLE system_book;

#Calendar
DROP TABLE user_task;

#University Map
DROP TABLE system_map_marker;

#Events
DROP TABLE system_event_booked;
DROP TABLE system_event;

#Messenger
DROP TABLE user_message_sent;
DROP TABLE user_message_received;
DROP TABLE user_message;

#Account
DROP TABLE paypal_log;
DROP TABLE user_fee;
DROP TABLE user_token;
DROP TABLE user_detail;
DROP TABLE user_signin;

#Account
CREATE TABLE `user_signin` (
  `userid` INT(11) NOT NULL AUTO_INCREMENT UNIQUE PRIMARY KEY,
  `account_type` VARCHAR(14) NOT NULL,
  `email` VARCHAR(300) NOT NULL UNIQUE,
  `password` CHAR(60) NOT NULL UNIQUE,
  `isSignedIn` TINYINT(1) NOT NULL,
  `created_on` DATETIME NOT NULL,
  `updated_on` DATETIME
) ENGINE = InnoDB;

#Account
CREATE TABLE `user_detail` (
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
  `user_status` VARCHAR(9) NOT NULL,
  `created_on` DATETIME NOT NULL,
  `updated_on` DATETIME,
FOREIGN KEY (userid)
REFERENCES user_signin(userid)
ON UPDATE CASCADE
ON DELETE CASCADE
) ENGINE = InnoDB;

#Account
CREATE TABLE `user_token` (
  `userid` INT(11) NOT NULL AUTO_INCREMENT UNIQUE,
  `token` CHAR(60) UNIQUE,
  `created_on` DATETIME,
FOREIGN KEY (userid)
REFERENCES user_signin(userid)
ON UPDATE CASCADE
ON DELETE CASCADE
) ENGINE = InnoDB;

#Account
CREATE TABLE `user_fee` (
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

#Account
CREATE TABLE `paypal_log` (
	`userid` INT(11) NOT NULL,
	`paymentid` INT(11) NOT NULL AUTO_INCREMENT UNIQUE PRIMARY KEY,
	`invoiceid` BIGINT(10) NOT NULL UNIQUE,
	`transactionid` VARCHAR(17) NOT NULL UNIQUE,
	`productid` INT(1) NOT NULL,
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
CREATE TABLE `user_message` (
	`messageid` INT(11) NOT NULL AUTO_INCREMENT UNIQUE PRIMARY KEY,
	`message_subject` VARCHAR(300) NOT NULL,
	`message_body` VARCHAR(10000) NOT NULL,
  `message_status` VARCHAR(9) NOT NULL,
  `created_on` DATETIME NOT NULL
) ENGINE = InnoDB;

#Messenger
CREATE TABLE `user_message_sent` (
  `messageid` INT(11) NOT NULL AUTO_INCREMENT,
  `message_from` INT(11) NOT NULL,
  `message_to` INT(11) NOT NULL,
FOREIGN KEY (messageid)
REFERENCES user_message(messageid),
FOREIGN KEY (message_from)
REFERENCES user_signin(userid),
FOREIGN KEY (message_to)
REFERENCES user_signin(userid)
ON UPDATE CASCADE
ON DELETE CASCADE
) ENGINE = InnoDB;

#Messenger
CREATE TABLE `user_message_received` (
  `messageid` INT(11) NOT NULL AUTO_INCREMENT,
  `message_from` INT(11) NOT NULL,
  `message_to` INT(11) NOT NULL,
  `isRead` TINYINT(1) NOT NULL,
FOREIGN KEY (messageid)
REFERENCES user_message(messageid),
FOREIGN KEY (message_from)
REFERENCES user_signin(userid),
FOREIGN KEY (message_to)
REFERENCES user_signin(userid)
ON UPDATE CASCADE
ON DELETE CASCADE
) ENGINE = InnoDB;

#Events
CREATE TABLE `system_event` (
	`eventid` INT(11) NOT NULL AUTO_INCREMENT UNIQUE PRIMARY KEY,
  `event_class` VARCHAR(15) NOT NULL,
	`event_name` VARCHAR(300) NOT NULL,
	`event_notes` VARCHAR(10000),
	`event_url` VARCHAR(300),
	`event_from` DATETIME NOT NULL,
	`event_to` DATETIME NOT NULL,
	`event_amount` NUMERIC(15,2) NOT NULL,
	`event_ticket_no` INT(11) NOT NULL,
	`event_status` VARCHAR(10) NOT NULL,
	`created_on` DATETIME NOT NULL,
	`updated_on` DATETIME
) ENGINE = InnoDB;

#Events
CREATE TABLE `system_event_booked` (
  `userid` INT(11) NOT NULL,
  `eventid` INT(11) NOT NULL,
  `event_class` VARCHAR(15) NOT NULL,
	`event_amount_paid` NUMERIC(15,2) NOT NULL,
	`ticket_quantity` INT(11) NOT NULL,
	`booked_on` DATETIME NOT NULL,
FOREIGN KEY (userid)
REFERENCES user_signin(userid),
FOREIGN KEY (eventid)
REFERENCES system_event(eventid)
ON UPDATE CASCADE
ON DELETE CASCADE
) ENGINE = InnoDB;

#University Map
CREATE TABLE `system_map_marker` (
  `markerid` INT(11) NOT NULL AUTO_INCREMENT UNIQUE PRIMARY KEY,
  `marker_name` VARCHAR(70) NOT NULL,
  `marker_notes` VARCHAR(10000),
  `marker_url` VARCHAR(300),
  `marker_lat` FLOAT(10,6) NOT NULL,
  `marker_long` FLOAT(10,6) NOT NULL,
  `marker_category` VARCHAR(70) NOT NULL,
  `marker_status` VARCHAR(9) NOT NULL,
  `created_on` DATETIME NOT NULL,
  `updated_on` DATETIME
) ENGINE = InnoDB;

#Calendar
CREATE TABLE `user_task` (
  `userid` INT(11) NOT NULL,
  `taskid` INT(11) NOT NULL AUTO_INCREMENT UNIQUE PRIMARY KEY,
  `task_name` VARCHAR(70) NOT NULL,
  `task_notes` VARCHAR(10000),
  `task_url` VARCHAR(300),
  `task_class` VARCHAR(15) NOT NULL,
  `task_startdate` DATETIME NOT NULL,
  `task_duedate` DATETIME NOT NULL,
  `task_status` VARCHAR(10) NOT NULL,
  `created_on` DATETIME NOT NULL,
  `updated_on` DATETIME,
  `completed_on` DATETIME,
FOREIGN KEY (userid)
REFERENCES user_signin(userid)
ON UPDATE CASCADE
ON DELETE CASCADE
) ENGINE = InnoDB;

#Library
CREATE TABLE `system_book` (
	`bookid` INT(11) NOT NULL AUTO_INCREMENT UNIQUE PRIMARY KEY,
	`book_name` VARCHAR(300) NOT NULL,
  `book_author` VARCHAR(300) NOT NULL,
  `book_notes` VARCHAR(10000),
  `book_copy_no` INT(11) NOT NULL,
  `book_location` VARCHAR(300) NOT NULL,
  `book_publisher` VARCHAR(300) NOT NULL,
  `book_publish_date` DATE NOT NULL,
  `book_publish_place` VARCHAR(300) NOT NULL,
  `book_page_amount` INT(11) NOT NULL,
  `book_barcode` INT(11) NOT NULL,
  `book_discipline` VARCHAR(300) NOT NULL,
  `book_language` VARCHAR(70) NOT NULL,
	`book_status` VARCHAR(9) NOT NULL,
  `isReserved` TINYINT(1) NOT NULL,
  `isLoaned` TINYINT(1) NOT NULL,
  `isRequested` TINYINT(1) NOT NULL,
	`created_on` DATETIME NOT NULL,
	`updated_on` DATETIME
) ENGINE = InnoDB;

#Library
CREATE TABLE `system_book_reserved` (
  `userid` INT(11) NOT NULL,
	`bookid` INT(11) NOT NULL,
  `reservationid` INT(11) NOT NULL AUTO_INCREMENT UNIQUE PRIMARY KEY,
	`tocollect_on` DATE NOT NULL,
  `collected_on` DATE NOT NULL,
	`isCollected` TINYINT(1) NOT NULL,
  `reservation_status` VARCHAR(9) NOT NULL,
  `created_on` DATETIME NOT NULL,
  `updated_on` DATETIME,
FOREIGN KEY (userid)
REFERENCES user_signin(userid),
FOREIGN KEY (bookid)
REFERENCES system_book(bookid)
ON UPDATE CASCADE
ON DELETE CASCADE
) ENGINE = InnoDB;

#Library
CREATE TABLE `system_book_loaned` (
  `userid` INT(11) NOT NULL,
  `bookid` INT(11) NOT NULL,
  `loanid` INT(11) NOT NULL AUTO_INCREMENT UNIQUE PRIMARY KEY,
  `book_class` VARCHAR(15) NOT NULL,
  `toreturn_on` DATE NOT NULL,
  `returned_on` DATE NOT NULL,
  `isReturned` TINYINT(1) NOT NULL,
  `isRequested` TINYINT(1) NOT NULL,
  `loan_status` VARCHAR(9) NOT NULL,
  `created_on` DATETIME NOT NULL,
  `updated_on` DATETIME,
FOREIGN KEY (userid)
REFERENCES user_signin(userid),
FOREIGN KEY (bookid)
REFERENCES system_book(bookid)
ON UPDATE CASCADE
ON DELETE CASCADE
) ENGINE = InnoDB;

#Library
CREATE TABLE `system_book_requested` (
  `userid` INT(11) NOT NULL,
  `bookid` INT(11) NOT NULL,
  `requestid` INT(11) NOT NULL AUTO_INCREMENT UNIQUE PRIMARY KEY,
  `isRead` TINYINT(1) NOT NULL,
  `isApproved` TINYINT(1) NOT NULL,
  `request_status` VARCHAR(9) NOT NULL,
  `created_on` DATETIME NOT NULL,
  `updated_on` DATETIME,
FOREIGN KEY (userid)
REFERENCES user_signin(userid),
FOREIGN KEY (bookid)
REFERENCES system_book(bookid)
ON UPDATE CASCADE
ON DELETE CASCADE
) ENGINE = InnoDB;

#Transport
CREATE TABLE `tube_line_status_now` (
  `statusid` INT(11) NOT NULL AUTO_INCREMENT UNIQUE PRIMARY KEY,
  `tube_lineid` INT(11) NOT NULL UNIQUE,
  `tube_line` VARCHAR (70) NOT NULL,
  `tube_line_status` VARCHAR (70),
  `tube_line_info` VARCHAR(10000),
  `updated_on` DATETIME NOT NULL
) ENGINE = InnoDB;

#Transport
CREATE TABLE `tube_station_status_now` (
  `statusid` INT(11) NOT NULL AUTO_INCREMENT UNIQUE PRIMARY KEY,
  `tube_stationid` INT(11) NOT NULL UNIQUE,
  `tube_station` VARCHAR (70) NOT NULL,
  `tube_station_status` VARCHAR (70),
  `tube_station_info` VARCHAR(10000),
  `updated_on` DATETIME NOT NULL
) ENGINE = InnoDB;

#Transport
CREATE TABLE `tube_line_status_this_weekend` (
  `statusid` INT(11) NOT NULL AUTO_INCREMENT UNIQUE PRIMARY KEY,
  `tube_line` VARCHAR (70) NOT NULL,
  `tube_line_status` VARCHAR (70),
  `tube_line_info` VARCHAR(10000),
  `updated_on` DATETIME NOT NULL
) ENGINE = InnoDB;

#Transport
CREATE TABLE `tube_station_status_this_weekend` (
  `statusid` INT(11) NOT NULL AUTO_INCREMENT UNIQUE PRIMARY KEY,
  `tube_station` VARCHAR (70) NOT NULL,
  `tube_station_status` VARCHAR (70),
  `tube_station_info` VARCHAR(10000),
  `updated_on` DATETIME NOT NULL
) ENGINE = InnoDB;

#Transport
CREATE TABLE `cycle_hire_status_now` (
  `statusid` INT NOT NULL AUTO_INCREMENT UNIQUE PRIMARY KEY,
  `dockid` INT NOT NULL UNIQUE,
  `dock_name` VARCHAR (70) NOT NULL,
  `dock_installed` VARCHAR (5),
  `dock_locked` VARCHAR(5),
  `dock_temporary` VARCHAR(5),
  `dock_bikes_available` INT(11),
  `dock_empty_docks` INT(11),
  `dock_total_docks` INT(11),
  `updated_on` DATETIME NOT NULL
) ENGINE = InnoDB;

#Timetable
CREATE TABLE `system_module` (
	`moduleid` INT(11) NOT NULL AUTO_INCREMENT UNIQUE PRIMARY KEY,
	`module_name` VARCHAR(300) NOT NULL,
	`module_notes` VARCHAR(10000),
	`module_url` VARCHAR(300),
	`module_status` VARCHAR(10) NOT NULL,
	`created_on` DATETIME NOT NULL,
	`updated_on` DATETIME
) ENGINE = InnoDB;

#Timetable
CREATE TABLE `user_module` (
  `userid` INT(11) NOT NULL,
  `moduleid` INT(11) NOT NULL,
FOREIGN KEY (userid)
REFERENCES user_signin(userid),
FOREIGN KEY (moduleid)
REFERENCES system_module(moduleid)
ON UPDATE CASCADE
ON DELETE CASCADE
) ENGINE = InnoDB;

#Timetable
CREATE TABLE `system_lecture` (
	`moduleid` INT(11) NOT NULL,
	`lectureid` INT(11) NOT NULL AUTO_INCREMENT UNIQUE PRIMARY KEY,
	`lecture_name` VARCHAR(300) NOT NULL,
	`lecture_lecturer` INT(11) NOT NULL,
	`lecture_notes` VARCHAR(10000),
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
REFERENCES system_module(moduleid)
ON UPDATE CASCADE
ON DELETE CASCADE
) ENGINE = InnoDB;

#Timetable
CREATE TABLE `user_lecture` (
  `userid` INT(11) NOT NULL,
  `lectureid` INT(11) NOT NULL,
FOREIGN KEY (userid)
REFERENCES user_signin(userid),
FOREIGN KEY (lectureid)
REFERENCES system_lecture(lectureid)
ON UPDATE CASCADE
ON DELETE CASCADE
) ENGINE = InnoDB;

#Timetable
CREATE TABLE `system_tutorial` (
	`moduleid` INT(11) NOT NULL,
	`tutorialid` INT(11) NOT NULL AUTO_INCREMENT UNIQUE PRIMARY KEY,
	`tutorial_name` VARCHAR(300) NOT NULL,
	`tutorial_assistant` INT(11) NOT NULL,
	`tutorial_notes` VARCHAR(10000),
	`tutorial_day` VARCHAR(9) NOT NULL,
	`tutorial_from_time` TIME NOT NULL,
	`tutorial_to_time` TIME NOT NULL,
	`tutorial_from_date` DATE NOT NULL,
	`tutorial_to_date` DATE NOT NULL,
	`tutorial_location` VARCHAR(300) NOT NULL,
	`tutorial_capacity` INT(11) NOT NULL,
	`tutorial_status` VARCHAR(9) NOT NULL,
	`created_on` DATETIME NOT NULL,
	`updated_on` DATETIME,
FOREIGN KEY (moduleid)
REFERENCES system_module(moduleid)
ON UPDATE CASCADE
ON DELETE CASCADE
) ENGINE = InnoDB;

#Timetable
CREATE TABLE `user_tutorial` (
  `userid` INT(11) NOT NULL,
  `tutorialid` INT(11) NOT NULL,
FOREIGN KEY (userid)
REFERENCES user_signin(userid),
FOREIGN KEY (tutorialid)
REFERENCES system_tutorial(tutorialid)
ON UPDATE CASCADE
ON DELETE CASCADE
) ENGINE = InnoDB;

#Timetable
CREATE TABLE `system_exam` (
	`moduleid` INT(11) NOT NULL,
	`examid` INT(11) NOT NULL AUTO_INCREMENT UNIQUE PRIMARY KEY,
	`exam_name` VARCHAR(300) NOT NULL,
	`exam_notes` VARCHAR(10000),
	`exam_date` DATE NOT NULL,
	`exam_time` TIME NOT NULL,
	`exam_location` VARCHAR(300) NOT NULL,
	`exam_capacity` INT(11) NOT NULL,
	`exam_status` VARCHAR(9) NOT NULL,
	`created_on` DATETIME NOT NULL,
	`updated_on` DATETIME,
FOREIGN KEY (moduleid)
REFERENCES system_module(moduleid)
ON UPDATE CASCADE
ON DELETE CASCADE
) ENGINE = InnoDB;

#Timetable
CREATE TABLE `user_exam` (
  `userid` INT(11) NOT NULL,
  `examid` INT(11) NOT NULL,
FOREIGN KEY (userid)
REFERENCES user_signin(userid),
FOREIGN KEY (examid)
REFERENCES system_exam(examid)
ON UPDATE CASCADE
ON DELETE CASCADE
) ENGINE = InnoDB;

#Results
CREATE TABLE `user_result` (
  `userid` INT(11) NOT NULL,
  `moduleid` INT(11) NOT NULL,
  `resultid` INT(11) NOT NULL AUTO_INCREMENT UNIQUE PRIMARY KEY,
  `result_coursework_mark` NUMERIC(15,2),
  `result_exam_mark` NUMERIC(15,2),
  `result_overall_mark` NUMERIC(15,2),
  `result_notes` VARCHAR(10000),
  `result_status` VARCHAR(9) NOT NULL,
  `created_on` DATETIME NOT NULL,
  `updated_on` DATETIME,
FOREIGN KEY (userid)
REFERENCES user_signin(userid),
FOREIGN KEY (moduleid)
REFERENCES system_module(moduleid)
ON UPDATE CASCADE
ON DELETE CASCADE
) ENGINE = InnoDB;

#Feedback
CREATE TABLE `user_feedback` (
  `moduleid` INT(11) NOT NULL,
  `feedbackid` INT(11) NOT NULL AUTO_INCREMENT UNIQUE PRIMARY KEY,
  `feedback_subject` VARCHAR(300) NOT NULL,
  `feedback_body` VARCHAR(10000) NOT NULL,
  `feedback_status` VARCHAR(9) NOT NULL,
  `isApproved` TINYINT(1) NOT NULL,
  `created_on` DATETIME NOT NULL,
FOREIGN KEY (moduleid)
REFERENCES system_module(moduleid)
) ENGINE = InnoDB;

#Feedback
CREATE TABLE `user_feedback_sent` (
  `feedbackid` INT(11) NOT NULL,
  `feedback_from` INT(11) NOT NULL,
  `moduleid` INT(11) NOT NULL,
  `module_staff` INT(11) NOT NULL,
FOREIGN KEY (feedbackid)
REFERENCES user_feedback(feedbackid),
FOREIGN KEY (feedback_from)
REFERENCES user_signin(userid),
FOREIGN KEY (moduleid)
REFERENCES system_module(moduleid),
FOREIGN KEY (module_staff)
REFERENCES user_signin(userid)
ON UPDATE CASCADE
ON DELETE CASCADE
) ENGINE = InnoDB;

#Feedback
CREATE TABLE `user_feedback_received` (
  `feedbackid` INT(11) NOT NULL,
  `feedback_from` INT(11) NOT NULL,
  `moduleid` INT(11) NOT NULL,
  `module_staff` INT(11) NOT NULL,
  `isRead` TINYINT(1) NOT NULL,
FOREIGN KEY (feedbackid)
REFERENCES user_feedback(feedbackid),
FOREIGN KEY (feedback_from)
REFERENCES user_signin(userid),
FOREIGN KEY (moduleid)
REFERENCES system_module(moduleid),
FOREIGN KEY (module_staff)
REFERENCES user_signin(userid)
ON UPDATE CASCADE
ON DELETE CASCADE
) ENGINE = InnoDB;