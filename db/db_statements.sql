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
	`studentno` VARCHAR(9) NOT NULL,
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
	`created_on` DATETIME NOT NULL,
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
	`created_on` DATETIME NOT NULL,
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