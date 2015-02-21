
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
	`address1` TEXT,
	`address2` TEXT,
	`city` TEXT,
	`state_prov` TEXT,
	`zip_postcode` TEXT,
	`country` TEXT,
	`telephone1` TEXT,
	`telephone2` TEXT,
	`email1` TEXT,
	`email2` TEXT,
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
#-- tribe
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `tribe`;


CREATE TABLE `tribe`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`name` TEXT,
	`location` TEXT,
	`retreat1_date` DATE,
	`retreat2_date` DATE,
	`retreat3_date` DATE,
	`retreat4_date` DATE,
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
#-- tribe_participant
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `tribe_participant`;


CREATE TABLE `tribe_participant`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`profile_id` INTEGER,
	`tribe_id` INTEGER,
	`role` VARCHAR(50),
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `tribe_participant_FI_1` (`profile_id`),
	CONSTRAINT `tribe_participant_FK_1`
		FOREIGN KEY (`profile_id`)
		REFERENCES `profile` (`id`)
		ON DELETE CASCADE,
	INDEX `tribe_participant_FI_2` (`tribe_id`),
	CONSTRAINT `tribe_participant_FK_2`
		FOREIGN KEY (`tribe_id`)
		REFERENCES `tribe` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- medical
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `medical`;


CREATE TABLE `medical`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`profile_id` INTEGER,
	`height` TEXT,
	`weight` TEXT,
	`conditions_physical` VARCHAR(10),
	`conditions_psychological` VARCHAR(10),
	`accommodations` TEXT,
	`head` VARCHAR(10),
	`neck` VARCHAR(10),
	`whiplash` VARCHAR(10),
	`shoulders` VARCHAR(10),
	`arms` VARCHAR(10),
	`wrists` VARCHAR(10),
	`hands` VARCHAR(10),
	`upper_back` VARCHAR(10),
	`lower_back` VARCHAR(10),
	`pelvis` VARCHAR(10),
	`groin` VARCHAR(10),
	`dislocations` VARCHAR(10),
	`dislocations_where` TEXT,
	`asthma` VARCHAR(10),
	`do_you_smoke` VARCHAR(10),
	`have_you_ever_smoked` VARCHAR(10),
	`are_you_currently_pregnant` VARCHAR(10),
	`due_date` DATE,
	`lower_legs` VARCHAR(10),
	`thighs` VARCHAR(10),
	`knees` VARCHAR(10),
	`ankles` VARCHAR(10),
	`feet` VARCHAR(10),
	`internal_organs` VARCHAR(10),
	`heart` VARCHAR(10),
	`lungs` VARCHAR(10),
	`ears` VARCHAR(10),
	`eyes` VARCHAR(10),
	`contact_lenses` VARCHAR(10),
	`dizziness` VARCHAR(10),
	`high_blood_pressure` VARCHAR(10),
	`heart_attack` VARCHAR(10),
	`diabetes` VARCHAR(10),
	`epilepsy_seizures` VARCHAR(10),
	`other_serious_illness` VARCHAR(10),
	`explanation` TEXT,
	`allergies` TEXT,
	`medications` VARCHAR(10),
	`name_of_medications` TEXT,
	`what_are_medications_for` TEXT,
	`medication_dosages` TEXT,
	`emergency_contact_name` TEXT,
	`emergency_relationship` TEXT,
	`emergency_address` TEXT,
	`emergency_work_phone` TEXT,
	`emergency_home_phone` TEXT,
	`emergency_other_phone` TEXT,
	`coverage_provider` TEXT,
	`policy_number` TEXT,
	`other_insurance_information` TEXT,
	`doctors_name` TEXT,
	`doctors_contact_info` TEXT,
	`release_of_liability` VARCHAR(50),
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
	INDEX `medical_FI_1` (`profile_id`),
	CONSTRAINT `medical_FK_1`
		FOREIGN KEY (`profile_id`)
		REFERENCES `profile` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- program_questionnaire
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `program_questionnaire`;


CREATE TABLE `program_questionnaire`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`profile_id` INTEGER,
	`nationality` TEXT,
	`relationship_status` TEXT,
	`current_profession` TEXT,
	`past_profession` TEXT,
	`personal_professional_goals` TEXT,
	`strengths` TEXT,
	`holds_you_back` TEXT,
	`handle_failing` TEXT,
	`willing_to_fail` TEXT,
	`willing_to_listen` TEXT,
	`therapy` VARCHAR(10),
	`therapy_details` TEXT,
	`therapy_impact` TEXT,
	`fundamentals` INTEGER,
	`intermediate_curriculum` INTEGER,
	`certification` INTEGER,
	`quest` INTEGER,
	`icc_curriculum` INTEGER,
	`have_a_coach` VARCHAR(10),
	`coaching_impact` TEXT,
	`religious_affiliations` TEXT,
	`religious_influences` TEXT,
	`growth_experiences` TEXT,
	`impact_as_a_leader` TEXT,
	`challenge` TEXT,
	`why_this_program` TEXT,
	`play_level` VARCHAR(50),
	`what_would_it_take` TEXT,
	`bring_yourself_back` TEXT,
	`going_the_distance` TEXT,
	`i_was_born_to` TEXT,
	`comments` TEXT,
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
	INDEX `program_questionnaire_FI_1` (`profile_id`),
	CONSTRAINT `program_questionnaire_FK_1`
		FOREIGN KEY (`profile_id`)
		REFERENCES `profile` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- dietary
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `dietary`;


CREATE TABLE `dietary`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`profile_id` INTEGER,
	`poultry` VARCHAR(10),
	`beef` VARCHAR(10),
	`vegetarian` VARCHAR(10),
	`seafood` VARCHAR(10),
	`lamb` VARCHAR(10),
	`vegan` VARCHAR(10),
	`pork` VARCHAR(10),
	`dietary_restrictions` VARCHAR(10),
	`describe_restrictions` TEXT,
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
	INDEX `dietary_FI_1` (`profile_id`),
	CONSTRAINT `dietary_FK_1`
		FOREIGN KEY (`profile_id`)
		REFERENCES `profile` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- certification
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `certification`;


CREATE TABLE `certification`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`profile_id` INTEGER,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`address` TEXT,
	`address2` TEXT,
	`city` TEXT,
	`state_province` TEXT,
	`country` TEXT,
	`zip_postal_code` TEXT,
	`evening_phone` TEXT,
	`day_phone` TEXT,
	`email` TEXT,
	`fax` TEXT,
	`mobile` TEXT,
	`how_many_clients` TEXT,
	`month_to_begin` TEXT,
	`languages_coaching` TEXT,
	`date_completed_process` TEXT,
	`date_of_synergy` TEXT,
	`your_certified_coach` TEXT,
	`cpcc` VARCHAR(10),
	`pcc` VARCHAR(10),
	`mcc` VARCHAR(10),
	`your_coachs_email` TEXT,
	`call_length` TEXT,
	`times_a_month` TEXT,
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
	INDEX `certification_FI_1` (`profile_id`),
	CONSTRAINT `certification_FK_1`
		FOREIGN KEY (`profile_id`)
		REFERENCES `profile` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- pod
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `pod`;


CREATE TABLE `pod`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`name` TEXT,
	`location` TEXT,
	`start_date` DATE,
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
#-- pod_participant
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `pod_participant`;


CREATE TABLE `pod_participant`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`profile_id` INTEGER,
	`pod_id` INTEGER,
	`role` VARCHAR(50),
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `pod_participant_FI_1` (`profile_id`),
	CONSTRAINT `pod_participant_FK_1`
		FOREIGN KEY (`profile_id`)
		REFERENCES `profile` (`id`)
		ON DELETE CASCADE,
	INDEX `pod_participant_FI_2` (`pod_id`),
	CONSTRAINT `pod_participant_FK_2`
		FOREIGN KEY (`pod_id`)
		REFERENCES `pod` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
