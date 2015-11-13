#
# Table structure for table 'members'
#

CREATE TABLE `users` (
  `user_id` int(11) unsigned NOT NULL auto_increment,
  `user_forename` varchar(100) default NULL,
  `user_surname` varchar(100) default NULL,
  `user_email` varchar(100) NOT NULL default '',
  `user_password` varchar(32) NOT NULL default '',
  `user_role_id` int(10) default '2',
  PRIMARY KEY  (`user_id`)
);



#
# Dumping data for table 'members'
#

INSERT INTO `members` (`member_id`, `firstname`, `lastname`, `login`, `passwd`) VALUES("1", "Jatinder", "Thind", "phpsense", "ba018360fc26e0cc2e929b8e071f052d");
