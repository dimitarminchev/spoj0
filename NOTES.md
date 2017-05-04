## Import Structure 

sets
	<set-code>
		[set-info.conf -- future, for automatic import of a set]
		<problem-letter>
			test.in -- input data
			test.ans -- the correct answer
			[solution-<something>.{c,cpp,java}]
			[problem-info.conf -- future]
			[checker -- future]
							
## Database Structure 

users
	name
	password
	display-name
	comment
	
```
CREATE TABLE  `spoj`.`users` (
  `user_id` int(11) NOT NULL auto_increment,
  `name` char(16) NOT NULL COMMENT 'the username (for login)',
  `pass_md5` char(64) NOT NULL,
  `display_name` char(64) NOT NULL COMMENT 'Full name (ex: coaches - Manev, Sredkov, Bogdanov)',
  `about` text NOT NULL COMMENT 'about the user',
  PRIMARY KEY  (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='User accounts (may be teams also)'
```	
	
contest
	contest_id -- int (primary key)
	set_code -- the contest short name (like fmi-2007-03-04)
	name -- full name (like "Вътрешна тренировка на fmi")
	start_time -- from what time the contest will be visible
	duration -- how long will it be in minutes (usually 300)
	show_sources (bool - whether to show sources '''after''' the contest)
	
```
CREATE TABLE  `spoj`.`contests` (
  `contest_id` int(11) NOT NULL auto_increment,
  `set_code` char(64) NOT NULL COMMENT 'the contest short name (like fmi-2007-03-04)',
  `name` char(128) NOT NULL comment 'full name (like "Вътрешна тренировка на fmi")',
  `start_time` datetime NOT NULL COMMENT 'from what time the contest will be visible',
  `duration` int not null comment 'how long will it be in minutes (usually 300)',
  `show_sources` bit not null comment 'whether to show the source after the contest',
  `about` text not null comment 'information about the contest',
  PRIMARY KEY  (`contest_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='User accounts (may be teams also)'
```

runs
	run_id -- int (primary key)
	problem_id -- fk
	user_id -- fk
	language (java, cpp ...)
	source-code -- the whole source code
	source-name -- the name of the source file (may be needed for java, or may be autodetected)
	status (waiting, judging,
	 
```
CREATE TABLE  `spoj`.`runs` (
  `run_id` int(11) NOT NULL auto_increment,
  `problem_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `language` char(16) NOT NULL COMMENT 'java, cpp ...',
  `source_code` mediumtext NOT NULL COMMENT 'the whole source code',
  `source_name` char(32) NOT NULL COMMENT 'may be needed for java, or may be autodetected',
  `about` text NOT NULL COMMENT 'notes about the code may be present',
  `status` char(16) NOT NULL COMMENT 'waiting, judging, ok, wa... ',
  `log` text NOT NULL COMMENT 'execution details',
  PRIMARY KEY  (`run_id`),
  KEY `fk_problems` (`problem_id`),
  KEY `fk_users` (`user_id`),
  CONSTRAINT `fk_problems` FOREIGN KEY (`problem_id`) REFERENCES `problems` (`problem_id`),
  CONSTRAINT `fk_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8
```

problems 
	problem_id -- pk
	contest_id -- fk
	letter -- the problem letter. must correspond to its directory
	name -- the full name of the problem
	time_limit -- the time limit in seconds
	about -- notes about the problem
	[checker -- future (diff, float(precision), etc)]
	[memory_limit] -- future

```
CREATE TABLE  `spoj`.`problems` (
  `problem_id` int(11) NOT NULL auto_increment,
  `contest_id` int(11) NOT NULL,
  `letter` char(16) NOT NULL COMMENT 'The problem letter. Must correspond to its directory.',
  `name` char(64) NOT NULL COMMENT 'the full name of the problem',
  `time_limit` int(11) NOT NULL COMMENT 'the time limit in seconds',
  `about` text NOT NULL COMMENT 'notes about the problem',
  PRIMARY KEY  (`problem_id`),
  KEY `new_fk_constraint` (`contest_id`),
  CONSTRAINT `new_fk_constraint` FOREIGN KEY (`contest_id`) REFERENCES `contests` (`contest_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8
```





