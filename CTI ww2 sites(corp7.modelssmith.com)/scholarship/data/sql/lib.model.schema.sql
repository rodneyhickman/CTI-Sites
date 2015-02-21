
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
	`full_name` TEXT,
	`first_name` TEXT,
	`middle_name` TEXT,
	`last_name` TEXT,
	`perm_address1` TEXT,
	`perm_address2` TEXT,
	`perm_city` TEXT,
	`perm_state_prov` TEXT,
	`perm_zip_postcode` TEXT,
	`perm_country` TEXT,
	`other_address1` TEXT,
	`other_address2` TEXT,
	`other_city` TEXT,
	`other_state_prov` TEXT,
	`other_zip_postcode` TEXT,
	`other_country` TEXT,
	`telephone1` TEXT,
	`telephone2` TEXT,
	`email1` TEXT,
	`email2` TEXT,
	`referred_by` TEXT,
	`gender` VARCHAR(10),
	`age` TEXT,
	`secret` TEXT,
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
#-- leadership
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `leadership`;


CREATE TABLE `leadership`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`profile_id` INTEGER,
	`program_preference` TEXT,
	`preferred_date1` TEXT,
	`preferred_date2` TEXT,
	`preferred_date3` TEXT,
	`how_started` TEXT,
	`what_impact` TEXT,
	`why_take` TEXT,
	`desired_impact` TEXT,
	`how_accountable` TEXT,
	`what_bring` TEXT,
	`why_applying` TEXT,
	`what_size` TEXT,
	`background` TEXT,
	`understood_agreements` TEXT,
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
	INDEX `leadership_FI_1` (`profile_id`),
	CONSTRAINT `leadership_FK_1`
		FOREIGN KEY (`profile_id`)
		REFERENCES `profile` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- coachtraining
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `coachtraining`;


CREATE TABLE `coachtraining`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`profile_id` INTEGER,
	`program_preference` TEXT,
	`core_preferred_date1` TEXT,
	`core_preferred_date2` TEXT,
	`core_preferred_date3` TEXT,
	`cert_preferred_date1` TEXT,
	`cert_preferred_date2` TEXT,
	`cert_preferred_date3` TEXT,
	`what_choose` TEXT,
	`fundamentals_exp` TEXT,
	`your_vision` TEXT,
	`how_support` TEXT,
	`why_applying` TEXT,
	`what_size` TEXT,
	`background` TEXT,
	`anything_else` TEXT,
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
	INDEX `coachtraining_FI_1` (`profile_id`),
	CONSTRAINT `coachtraining_FK_1`
		FOREIGN KEY (`profile_id`)
		REFERENCES `profile` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- execcoach
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `execcoach`;


CREATE TABLE `execcoach`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`profile_id` INTEGER,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`bio_resume` TEXT,
	`photo` TEXT,
	`home_country` TEXT,
	`phone_home` TEXT,
	`phone_office` TEXT,
	`phone_mobile` TEXT,
	`skype` TEXT,
	`time_zone` TEXT,
	`language_fluency` TEXT,
	`education` TEXT,
	`certifications` TEXT,
	`authorized_to_work` TEXT,
	`years_cti` TEXT,
	`what_capacity` TEXT,
	`corporate_clients` TEXT,
	`training_style` TEXT,
	`publication_engagements` TEXT,
	`expertise` TEXT,
	`industries` TEXT,
	`types_of_coaching` TEXT,
	`number_of_executives` TEXT,
	`outcomes_tracked` TEXT,
	`work_visa` TEXT,
	`travel_visa` TEXT,
	`media_exposure` TEXT,
	`size_of_group` TEXT,
	`endorsements` TEXT,
	`utilization_corp_forl` TEXT,
	`utilization_corp_coach` TEXT,
	`utilization_exec_coach` TEXT,
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
	INDEX `execcoach_FI_1` (`profile_id`),
	CONSTRAINT `execcoach_FK_1`
		FOREIGN KEY (`profile_id`)
		REFERENCES `profile` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- leaders
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `leaders`;


CREATE TABLE `leaders`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`profile_id` INTEGER,
	`phone_office` TEXT,
	`time_zone` TEXT,
	`skype` TEXT,
	`education_history` TEXT,
	`credentials` TEXT,
	`resume` VARCHAR(255),
	`photo` VARCHAR(255),
	`language_fluency` TEXT,
	`leadership_tribe` TEXT,
	`assisted_in_tribe` VARCHAR(100),
	`tribe_name` TEXT,
	`leading_experience` TEXT,
	`enrollment_experience` TEXT,
	`leader_recommendation` VARCHAR(255),
	`why_want_to_lead` TEXT,
	`life_purpose` TEXT,
	`quest` TEXT,
	`initials` TEXT,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `leaders_FI_1` (`profile_id`),
	CONSTRAINT `leaders_FK_1`
		FOREIGN KEY (`profile_id`)
		REFERENCES `profile` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- leadersaux
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `leadersaux`;


CREATE TABLE `leadersaux`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`profile_id` INTEGER,
	`attribute` VARCHAR(50),
	`value` TEXT,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `leadersaux_FI_1` (`profile_id`),
	CONSTRAINT `leadersaux_FK_1`
		FOREIGN KEY (`profile_id`)
		REFERENCES `profile` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- flexform
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `flexform`;


CREATE TABLE `flexform`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`name` TEXT,
	`title` TEXT,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`extra1` TEXT,
	`extra2` TEXT,
	`extra3` TEXT,
	`extra4` TEXT,
	`extra5` TEXT,
	`extra6` TEXT,
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- flexform_question
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `flexform_question`;


CREATE TABLE `flexform_question`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`flexform_id` INTEGER,
	`type` VARCHAR(20),
	`number` VARCHAR(10),
	`label` TEXT,
	`param_name` VARCHAR(30),
	`options` TEXT,
	`css_class` TEXT,
	`display_order` INTEGER,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`extra1` TEXT,
	`extra2` TEXT,
	`extra3` TEXT,
	`extra4` TEXT,
	`extra5` TEXT,
	`extra6` TEXT,
	PRIMARY KEY (`id`),
	INDEX `flexform_question_FI_1` (`flexform_id`),
	CONSTRAINT `flexform_question_FK_1`
		FOREIGN KEY (`flexform_id`)
		REFERENCES `flexform` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- flexform_submission
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `flexform_submission`;


CREATE TABLE `flexform_submission`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`profile_id` INTEGER,
	`flexform_id` INTEGER,
	`submit_date` DATETIME,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`extra1` TEXT,
	`extra2` TEXT,
	`extra3` TEXT,
	`extra4` TEXT,
	`extra5` TEXT,
	`extra6` TEXT,
	PRIMARY KEY (`id`),
	INDEX `flexform_submission_FI_1` (`profile_id`),
	CONSTRAINT `flexform_submission_FK_1`
		FOREIGN KEY (`profile_id`)
		REFERENCES `profile` (`id`)
		ON DELETE CASCADE,
	INDEX `flexform_submission_FI_2` (`flexform_id`),
	CONSTRAINT `flexform_submission_FK_2`
		FOREIGN KEY (`flexform_id`)
		REFERENCES `flexform` (`id`)
		ON DELETE SET NULL
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- flexform_answer
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `flexform_answer`;


CREATE TABLE `flexform_answer`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`flexform_submission_id` INTEGER,
	`flexform_question_id` INTEGER,
	`content` TEXT,
	`type` VARCHAR(20),
	`number` VARCHAR(10),
	`label` TEXT,
	`param_name` VARCHAR(30),
	`options` TEXT,
	`css_class` TEXT,
	`display_order` INTEGER,
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
	PRIMARY KEY (`id`),
	INDEX `flexform_answer_FI_1` (`flexform_submission_id`),
	CONSTRAINT `flexform_answer_FK_1`
		FOREIGN KEY (`flexform_submission_id`)
		REFERENCES `flexform_submission` (`id`)
		ON DELETE CASCADE,
	INDEX `flexform_answer_FI_2` (`flexform_question_id`),
	CONSTRAINT `flexform_answer_FK_2`
		FOREIGN KEY (`flexform_question_id`)
		REFERENCES `flexform_question` (`id`)
		ON DELETE SET NULL
)Type=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
