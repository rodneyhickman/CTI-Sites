
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- profile
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `profile`;


CREATE TABLE `profile`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`fmid` INTEGER,
	`name` TEXT,
	`email` TEXT,
	`purpose` TEXT,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`extra1` TEXT,
	`extra2` TEXT,
	`extra3` TEXT,
	`extra4` TEXT,
	`extra5` TEXT,
	`extra6` TEXT,
	`extra7` TEXT,
	`extra8` TEXT,
	`extra9` TEXT,
	`extra10` TEXT,
	`extra11` TEXT,
	`extra12` TEXT,
	`extra13` TEXT,
	`extra14` TEXT,
	`extra15` TEXT,
	`extra16` TEXT,
	`extra17` TEXT,
	`extra18` TEXT,
	`extra19` TEXT,
	`extra20` TEXT,
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- group
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `group`;


CREATE TABLE `group`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`start_date` DATE,
	`name` TEXT,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`extra1` TEXT,
	`extra2` TEXT,
	`extra3` TEXT,
	`extra4` TEXT,
	`extra5` TEXT,
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- homework
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `homework`;


CREATE TABLE `homework`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`profile_id` INTEGER,
	`group_id` INTEGER,
	`week_starting` DATE,
	`ss_commit` INTEGER,
	`ss_completed` INTEGER,
	`clients_commit` INTEGER,
	`clients_completed` INTEGER,
	`points_commit` INTEGER,
	`points_earned` INTEGER,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`extra1` TEXT,
	`extra2` TEXT,
	`extra3` TEXT,
	`extra4` TEXT,
	`extra5` TEXT,
	`extra6` TEXT,
	`extra7` TEXT,
	`extra8` TEXT,
	`extra9` TEXT,
	`extra10` TEXT,
	`extra11` TEXT,
	`extra12` TEXT,
	`extra13` TEXT,
	`extra14` TEXT,
	`extra15` TEXT,
	`extra16` TEXT,
	`extra17` TEXT,
	`extra18` TEXT,
	`extra19` TEXT,
	`extra20` TEXT,
	PRIMARY KEY (`id`),
	INDEX `homework_FI_1` (`profile_id`),
	CONSTRAINT `homework_FK_1`
		FOREIGN KEY (`profile_id`)
		REFERENCES `profile` (`id`)
		ON DELETE CASCADE,
	INDEX `homework_FI_2` (`group_id`),
	CONSTRAINT `homework_FK_2`
		FOREIGN KEY (`group_id`)
		REFERENCES `group` (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- audio
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `audio`;


CREATE TABLE `audio`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`profile_id` INTEGER,
	`description` TEXT,
	`url` TEXT,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`extra1` TEXT,
	`extra2` TEXT,
	`extra3` TEXT,
	`extra4` TEXT,
	`extra5` TEXT,
	`extra6` TEXT,
	`extra7` TEXT,
	`extra8` TEXT,
	`extra9` TEXT,
	`extra10` TEXT,
	`extra11` TEXT,
	`extra12` TEXT,
	`extra13` TEXT,
	`extra14` TEXT,
	`extra15` TEXT,
	`extra16` TEXT,
	`extra17` TEXT,
	`extra18` TEXT,
	`extra19` TEXT,
	`extra20` TEXT,
	PRIMARY KEY (`id`),
	INDEX `audio_FI_1` (`profile_id`),
	CONSTRAINT `audio_FK_1`
		FOREIGN KEY (`profile_id`)
		REFERENCES `profile` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- document
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `document`;


CREATE TABLE `document`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`profile_id` INTEGER,
	`description` TEXT,
	`url` TEXT,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`extra1` TEXT,
	`extra2` TEXT,
	`extra3` TEXT,
	`extra4` TEXT,
	`extra5` TEXT,
	`extra6` TEXT,
	`extra7` TEXT,
	`extra8` TEXT,
	`extra9` TEXT,
	`extra10` TEXT,
	`extra11` TEXT,
	`extra12` TEXT,
	`extra13` TEXT,
	`extra14` TEXT,
	`extra15` TEXT,
	`extra16` TEXT,
	`extra17` TEXT,
	`extra18` TEXT,
	`extra19` TEXT,
	`extra20` TEXT,
	PRIMARY KEY (`id`),
	INDEX `document_FI_1` (`profile_id`),
	CONSTRAINT `document_FK_1`
		FOREIGN KEY (`profile_id`)
		REFERENCES `profile` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
