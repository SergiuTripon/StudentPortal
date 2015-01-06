DROP TABLE paypal_log; 
DROP TABLE user_details; 
DROP TABLE user_fees; 
DROP TABLE user_token; 
DROP TABLE user_tasks; 
DROP TABLE user_signin; 

CREATE TABLE `student_portal`.`user_signin` (
	`userid` INT(11) NOT NULL AUTO_INCREMENT UNIQUE PRIMARY KEY,
	`account_type` VARCHAR(8) NOT NULL,
	`email` VARCHAR(300) NOT NULL UNIQUE,
	`password` CHAR(70) NOT NULL UNIQUE
) ENGINE = InnoDB;

CREATE TABLE `student_portal`.`user_token` (
	`userid` INT(11) NOT NULL AUTO_INCREMENT UNIQUE,
	`token` CHAR(70) UNIQUE,
	`created_date` DATETIME NOT NULL,
	`updated_date` DATETIME,
FOREIGN KEY (userid)    
REFERENCES user_signin(userid)   
ON UPDATE CASCADE   
ON DELETE CASCADE   
) ENGINE = InnoDB; 

CREATE TABLE `student_portal`.`user_details` (
	`userid` INT(11) NOT NULL AUTO_INCREMENT UNIQUE,
	`studentno` INT(9) NOT NULL UNIQUE,
	`firstname` VARCHAR(70) NOT NULL,
	`surname` VARCHAR(70) NOT NULL,
	`gender` VARCHAR(6) NOT NULL,
	`dateofbirth` DATE,
	`phonenumber` VARCHAR(70),
	`degree` VARCHAR(70),
	`address1` VARCHAR(70),
	`address2` VARCHAR(70),
	`town` VARCHAR(70),
	`city` VARCHAR(70),
	`country` VARCHAR(70),
	`postcode` VARCHAR(70),
	`created_date` DATETIME NOT NULL,
	`updated_date` DATETIME,
FOREIGN KEY (userid)    
REFERENCES user_signin(userid)   
ON UPDATE CASCADE   
ON DELETE CASCADE   
) ENGINE = InnoDB;  


CREATE TABLE `student_portal`.`user_fees` (
	`userid` INT(11) NOT NULL AUTO_INCREMENT UNIQUE,
	`fee_amount` NUMERIC(15,2) NOT NULL,
	`updated_on` DATETIME,
FOREIGN KEY (userid)    
REFERENCES user_signin(userid)   
ON UPDATE CASCADE   
ON DELETE CASCADE   
) ENGINE = InnoDB;   

CREATE TABLE `student_portal`.`paypal_log` (
	`userid` INT(11) NOT NULL,
	`isHalf` TINYINT(1) NOT NULL,
	`invoice_id` INT(10) NOT NULL,
	`transaction_id` VARCHAR(17) NOT NULL,
	`product_id` INT(1) NOT NULL,
	`product_name` VARCHAR(9) NOT NULL,
	`product_quantity` INT(1) NOT NULL,
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
	`payment_status` VARCHAR(9) NOT NULL,
	`created_date` DATETIME NOT NULL,
	`completed_date` DATETIME,
	`cancelled_date` DATETIME,
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
	`created_date` DATETIME NOT NULL,
	`updated_date` DATETIME,
	`completed_date` DATETIME,
FOREIGN KEY (userid)    
REFERENCES user_signin(userid)   
ON UPDATE CASCADE   
ON DELETE CASCADE   
) ENGINE = InnoDB;

INSERT INTO `user_signin`(`userid`, `account_type`, `email`, `password`) 
VALUES ('1', 'admin', 'admin1@student-portal.co.uk', '$2y$10$/7iGAzsQsCBPoWDfwTsYtegbfIFNo37YFE9bVLE4SjzH0k8Yg0lnm');
INSERT INTO `user_fees`(`userid`, `fee_amount`) VALUES ('1', '0.00');
INSERT INTO `user_details`(`userid`, `studentno`, `firstname`, `surname`, `gender`, `dateofbirth`, `phonenumber`, `degree`, `address1`, `address2`, `town`, `city`, `postcode`) 
VALUES ('1',NULL,'Admin1','', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `user_token`(`userid`, `token`) VALUES ('1', NULL);

INSERT INTO `user_signin`(`userid`, `account_type`, `email`, `password`)
VALUES ('2', 'admin', 'admin2@student-portal.co.uk', '$2y$10$Uz5vqLJFmr6qsJAEXJnARuZRtoIDW9LLaZRWKCUKkUZmYFuTAaDn6');
INSERT INTO `user_fees`(`userid`, `fee_amount`) VALUES ('2', '0.00');
INSERT INTO `user_details`(`userid`, `studentno`, `firstname`, `surname`, `gender`,`dateofbirth`, `phonenumber`, `degree`, `address1`, `address2`, `town`, `city`, `postcode`) 
VALUES ('2',NULL,'Admin2','', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `user_token`(`userid`, `token`) VALUES ('2', NULL);

INSERT INTO `user_signin`(`userid`, `account_type`, `email`, `password`) 
VALUES ('3', 'admin', 'admin3@student-portal.co.uk', '$2y$10$d8VTH85HUHxzSrIpAMLTHeWKpkLIaRnhDyg/KY4EYQC6IPfYHSLcm');
INSERT INTO `user_fees`(`userid`, `fee_amount`) VALUES ('3', '0.00');
INSERT INTO `user_details`(`userid`, `studentno`, `firstname`, `surname`, `gender`, `dateofbirth`, `phonenumber`, `degree`, `address1`, `address2`, `town`, `city`, `postcode`) 
VALUES ('3',NULL,'Admin3','', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `user_token`(`userid`, `token`) VALUES ('3', NULL);

INSERT INTO `user_signin`(`userid`, `account_type`, `email`, `password`)
VALUES ('4', 'student', 'contact@sergiu-tripon.com', '$2y$10$J9/evRbEdIT0BqUcj/9oAOPJdirEiZT2yVJxLnoODlOwvBT4accI2');
INSERT INTO `user_fees`(`userid`, `fee_amount`) VALUES ('4', '0.00');
INSERT INTO `user_details`(`userid`, `studentno`, `firstname`, `surname`, `gender`, `dateofbirth`, `phonenumber`, `degree`, `address1`, `address2`, `town`, `city`, `postcode`)
VALUES ('4',NULL,'Sergiu','Tripon', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `user_token`(`userid`, `token`) VALUES ('4', NULL);