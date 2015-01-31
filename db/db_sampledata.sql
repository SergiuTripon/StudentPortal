INSERT INTO `user_signin`(`userid`, `account_type`, `email`, `password`)
VALUES ('1', 'admin', 'admin@student-portal.co.uk', '$2y$10$2UOneiOEmmi6kI4DG0di4u2/8oOsdpYDRsc8XzoM2.nKx3ZErPjEe');
INSERT INTO `user_fees`(`userid`, `fee_amount`) VALUES ('1', '0.00');
INSERT INTO `user_details`(`userid`, `studentno`, `firstname`, `surname`, `gender`, `dateofbirth`, `phonenumber`, `degree`, `address1`, `address2`, `town`, `city`, `postcode`)
VALUES ('1',NULL,'Admin','', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `user_token`(`userid`, `token`) VALUES ('1', NULL);