## Import Structure 
File structure of the single contest: 
```
sets
	<set-code>
		[set-info.conf -- future, for automatic import of a set]
		<problem-letter>
			test.in -- input data
			test.ans -- the correct answer
			[solution-<something>.{c,cpp,java}]
			[problem-info.conf -- future]
			[checker -- future]
```
## Database Structure 
Table:
```
users
	user_id = pk
	name = user name
	pass_md5 = user password
	display-name = user display name
	about = info about the user
```
Query:
```
CREATE TABLE  `users` (
  `user_id` int(11) NOT NULL auto_increment,
  `name` char(16) NOT NULL,
  `pass_md5` char(64) NOT NULL,
  `display_name` char(64) NOT NULL,
  `about` text NOT NULL,
  PRIMARY KEY  (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='User or team accounts'
```	
Table :
```
contest
	contest_id = pk
	set_code = the contest short name
	name = full name
	start_time = from what time the contest will be visible
	duration = how long will it be in minutes (usually 300)
	show_sources = [bool - whether to show sources after the contest ends]
	about = information about the contest
```
Query:
```
CREATE TABLE  `contests` (
  `contest_id` int(11) NOT NULL auto_increment,
  `set_code` char(64) NOT NULL,
  `name` char(128) NOT NULL,
  `start_time` datetime NOT NULL,
  `duration` int NOT NULL,
  `show_sources` bit NOT NULL,
  `about` text NOT NULL,
  PRIMARY KEY  (`contest_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Contests'
```
Table:
```
runs
	run_id = pk
	problem_id = fk
	user_id = fk
	language = [cpp, cs, java]
	source-code = the whole source code
	source-name = the name of the source file (may be needed for java, or may be autodetected)
	about = notes about the code may be present
	status = [waiting, judging, ok, wa, ce, re, tl]	 
	log = execution details
```
Query:
```
CREATE TABLE  `runs` (
  `run_id` int(11) NOT NULL auto_increment,
  `problem_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `language` char(16) NOT NULL,
  `source_code` mediumtext NOT NULL,
  `source_name` char(32) NOT NULL,
  `about` text NOT NULL,
  `status` char(16) NOT NULL,
  `log` text NOT NULL,
  PRIMARY KEY  (`run_id`),
  KEY `fk_problems` (`problem_id`),
  KEY `fk_users` (`user_id`),
  CONSTRAINT `fk_problems` FOREIGN KEY (`problem_id`) REFERENCES `problems` (`problem_id`),
  CONSTRAINT `fk_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Submitions'
```
Table:
```
problems 
	problem_id = pk
	contest_id = fk
	letter = the problem letter. must correspond to its directory
	name = the full name of the problem
	time_limit = the time limit in seconds
	about = notes about the problem
```
Query:
```
CREATE TABLE  `problems` (
  `problem_id` int(11) NOT NULL auto_increment,
  `contest_id` int(11) NOT NULL,
  `letter` char(16) NOT NULL,
  `name` char(64) NOT NULL,
  `time_limit` int(11) NOT NULL,
  `about` text NOT NULL,
  PRIMARY KEY  (`problem_id`),
  KEY `new_fk_constraint` (`contest_id`),
  CONSTRAINT `new_fk_constraint` FOREIGN KEY (`contest_id`) REFERENCES `contests` (`contest_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8  COMMENT='Problems';
```
Table:
```
news
	new_id = pk
	new_time = when the new is submited
	file = the file that the new came from
	topic = the title of the news
	content = the content of the news
```
Query:
```
CREATE TABLE `news` (
  `new_id` int(11) NOT NULL auto_increment,
  `new_time` datetime NOT NULL,
  `file` char(64) NOT NULL,
  `topic` char(128) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY  (`new_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='News';
```
Table:
```
questions
	question_id = pk
	problem_id = fk
	user_id = fk
	question_time = datetime when the question is submited
	content = the questions contents
	status = status of the question
	answer_time = datetime when the answer is submited
	answer_content = the answer text content
```
Query:
```
CREATE TABLE `questions` (
  `question_id` int(11) NOT NULL AUTO_INCREMENT,
  `problem_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `question_time` datetime NOT NULL,
  `content` text NOT NULL,
  `status` char(32) NOT NULL,
  `answer_time` datetime NOT NULL,
  `answer_content` text NOT NULL,
  PRIMARY KEY (`question_id`),
  KEY `fk2_problems` (`problem_id`),
  KEY `fk2_users` (`user_id`),
  CONSTRAINT `fk2_problems` FOREIGN KEY (`problem_id`) REFERENCES `problems`
(`problem_id`),
  CONSTRAINT `fk2_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Questions';
```
