
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- student
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `student`;


CREATE TABLE `student`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`profile_id` INTEGER,
	`fm_id` INTEGER,
	`name` VARCHAR(100),
	`email` VARCHAR(100),
	`level` INTEGER,
	`last_activity` DATE,
	`in_the_bones_date` DATE,
	`course_fundamentals` VARCHAR(25),
	`course_fulfillment` VARCHAR(25),
	`course_balance` VARCHAR(25),
	`course_process` VARCHAR(25),
	`course_in_the_bones` VARCHAR(25),
	`cpcc_cert_date` DATE,
	`cpcc_grad` VARCHAR(25),
	`course_certification` VARCHAR(25),
	`cti_faculty` VARCHAR(25),
	`active` VARCHAR(25),
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `student_FI_1` (`profile_id`),
	CONSTRAINT `student_FK_1`
		FOREIGN KEY (`profile_id`)
		REFERENCES `profile` (`id`)
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- profile
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `profile`;


CREATE TABLE `profile`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(100),
	`email` VARCHAR(100),
	`location` VARCHAR(100),
	`niche` TEXT,
	`expertise` TEXT,
	`sf_guard_user_id` INTEGER,
	`agree_clicked` DATETIME,
	`number_of_contacts_made` INTEGER,
	`phone` VARCHAR(100),
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`)
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- profile_extra
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `profile_extra`;


CREATE TABLE `profile_extra`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`profile_id` INTEGER,
	`attribute` VARCHAR(100),
	`value` TEXT,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `profile_extra_FI_1` (`profile_id`),
	CONSTRAINT `profile_extra_FK_1`
		FOREIGN KEY (`profile_id`)
		REFERENCES `profile` (`id`)
		ON DELETE CASCADE
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- activity
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `activity`;


CREATE TABLE `activity`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`client_id` INTEGER,
	`coach_id` INTEGER,
	`activity_date` DATETIME,
	`decription` VARCHAR(100),
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `activity_FI_1` (`client_id`),
	CONSTRAINT `activity_FK_1`
		FOREIGN KEY (`client_id`)
		REFERENCES `profile` (`id`)
		ON DELETE CASCADE,
	INDEX `activity_FI_2` (`coach_id`),
	CONSTRAINT `activity_FK_2`
		FOREIGN KEY (`coach_id`)
		REFERENCES `profile` (`id`)
		ON DELETE CASCADE
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- feedback
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `feedback`;


CREATE TABLE `feedback`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`profile_id` INTEGER,
	`feedback_date` DATETIME,
	`attribute` VARCHAR(100),
	`value` TEXT,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `feedback_FI_1` (`profile_id`),
	CONSTRAINT `feedback_FK_1`
		FOREIGN KEY (`profile_id`)
		REFERENCES `profile` (`id`)
		ON DELETE CASCADE
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- course_dates
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `course_dates`;


CREATE TABLE `course_dates`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`profile_id` INTEGER,
	`course` VARCHAR(100),
	`course_date` DATETIME,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `course_dates_FI_1` (`profile_id`),
	CONSTRAINT `course_dates_FK_1`
		FOREIGN KEY (`profile_id`)
		REFERENCES `profile` (`id`)
		ON DELETE CASCADE
)Type=MyISAM;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
