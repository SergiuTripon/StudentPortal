#User dummy data
INSERT INTO `user_signin`(`userid`, `account_type`, `email`, `password`, `created_on`) VALUES ('1', 'admin', 'admin@student-portal.co.uk', '$2y$10$2UOneiOEmmi6kI4DG0di4u2/8oOsdpYDRsc8XzoM2.nKx3ZErPjEe', '0000-00-00 00:00:00');
INSERT INTO `user_fees`(`userid`, `fee_amount`, `created_on`) VALUES ('1', '0.00', '0000-00-00 00:00:00');
INSERT INTO `user_details`(`userid`, `studentno`, `firstname`, `surname`, `gender`, `dateofbirth`, `phonenumber`, `degree`, `address1`, `address2`, `town`, `city`, `country`, `postcode`, `created_on`) VALUES ('1','1','Admin','strator', 'male', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00');
INSERT INTO `user_token`(`userid`, `token`, `created_on`) VALUES ('1', NULL, '0000-00-00 00:00:00');

#Timetable dummy data
INSERT INTO `system_modules`(`moduleid`, `module_name`, `module_notes`, `module_url`, `module_status`, `created_on`, `updated_on`) VALUES ('1','Theory of Computation','','','active','0000-00-00 00:00:00','');
INSERT INTO `system_lectures`(`moduleid`,`lectureid`, `lecture_lecturer`, `lecture_name`, `lecture_notes`, `lecture_day`, `lecture_from_time`, `lecture_to_time`, `lecture_from_date`, `lecture_to_date`, `lecture_location`, `lecture_capacity`, `lecture_status`, `created_on`, `updated_on`) VALUES ('1','1','2','Theory of Computation - Lecture', '','Monday','15:00:00', '17:00:00', '2015-02-01','2015-03-01','Great Hall', '150','active','0000-00-00 00:00:00','');
INSERT INTO `system_tutorials`(`moduleid`, `tutorialid`, `tutorial_assistant`, `tutorial_name`, `tutorial_notes`, `tutorial_day`, `tutorial_from_time`, `tutorial_to_time`, `tutorial_from_date`, `tutorial_to_date`, `tutorial_location`, `tutorial_capacity`, `tutorial_status`, `created_on`, `updated_on`) VALUES ('1','1','2','Theory of Computation - Tutorial','','Tuesday','11:00:00','13:00:00','2015-02-01','2015-03-01', 'EG12', '30','active','0000-00-00 0000:00:00','');
INSERT INTO `system_exams`(`moduleid`, `examid`, `exam_name`, `exam_notes`, `exam_date`, `exam_time`, `exam_location`, `exam_capacity`, `exam_status`, `created_on`, `updated_on`) VALUES ('1', '1','Theory of Computation - Exam','','2015-03-01','14:00:00','The Crypt','40','active','0000-00-00 00:00:00', '');
INSERT INTO `user_timetable`(`userid`, `moduleid`) VALUES (2,1);

#SELECT system_lectures.lecture_name, system_tutorials.tutorial_name FROM user_timetable
#LEFT JOIN system_modules ON user_timetable.moduleid=system_modules.moduleid
#LEFT JOIN system_lectures ON user_timetable.moduleid=system_lectures.moduleid
#LEFT JOIN system_tutorials ON user_timetable.moduleid=system_tutorials.moduleid
#WHERE user_timetable.userid = 1 AND system_lectures.lecture_day = 'Monday' AND system_tutorials.tutorial_day <> 'Tuesday';

#Events dummy data
INSERT INTO `system_events`(`eventid`, `event_name`, `event_notes`, `event_url`, `event_class`, `event_from`, `event_to`, `event_amount`, `event_ticket_no`, `event_category`, `event_status`, `created_on`, `updated_on`) VALUES (1,'City Careers','','','event-important','2015-03-02 16:00:00','2015-03-02 19:00:00','10.00','50','Careers','active','0000-00-00 0000:00:00','');

#Library dummy data
INSERT INTO `system_books`(`bookid`, `book_name`, `book_author`, `book_notes`, `book_copy_no`, `book_status`, `created_on`, `updated_on`) VALUES ('2','Da Vinci Code','Dan Brown','','2','available','0000-00-00 00:00:00','');

INSERT INTO `user_messages`(`userid`, `messageid`, `message_subject`, `message_body`, `message_to`, `isRead`, `created_on`, `deleted_on`) VALUES ('1','','','2','','','','')