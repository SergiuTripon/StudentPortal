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