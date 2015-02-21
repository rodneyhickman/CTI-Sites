<?php


/**
 * This class defines the structure of the 'program_questionnaire' table.
 *
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * Fri Nov 11 20:46:58 2011
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class ProgramQuestionnaireTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.ProgramQuestionnaireTableMap';

	/**
	 * Initialize the table attributes, columns and validators
	 * Relations are not initialized by this method since they are lazy loaded
	 *
	 * @return     void
	 * @throws     PropelException
	 */
	public function initialize()
	{
	  // attributes
		$this->setName('program_questionnaire');
		$this->setPhpName('ProgramQuestionnaire');
		$this->setClassname('ProgramQuestionnaire');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
		$this->addForeignKey('PROFILE_ID', 'ProfileId', 'INTEGER', 'profile', 'ID', false, null, null);
		$this->addColumn('NATIONALITY', 'Nationality', 'LONGVARCHAR', false, null, null);
		$this->addColumn('RELATIONSHIP_STATUS', 'RelationshipStatus', 'LONGVARCHAR', false, null, null);
		$this->addColumn('CURRENT_PROFESSION', 'CurrentProfession', 'LONGVARCHAR', false, null, null);
		$this->addColumn('PAST_PROFESSION', 'PastProfession', 'LONGVARCHAR', false, null, null);
		$this->addColumn('PERSONAL_PROFESSIONAL_GOALS', 'PersonalProfessionalGoals', 'LONGVARCHAR', false, null, null);
		$this->addColumn('STRENGTHS', 'Strengths', 'LONGVARCHAR', false, null, null);
		$this->addColumn('HOLDS_YOU_BACK', 'HoldsYouBack', 'LONGVARCHAR', false, null, null);
		$this->addColumn('HANDLE_FAILING', 'HandleFailing', 'LONGVARCHAR', false, null, null);
		$this->addColumn('WILLING_TO_FAIL', 'WillingToFail', 'LONGVARCHAR', false, null, null);
		$this->addColumn('WILLING_TO_LISTEN', 'WillingToListen', 'LONGVARCHAR', false, null, null);
		$this->addColumn('THERAPY', 'Therapy', 'VARCHAR', false, 10, null);
		$this->addColumn('THERAPY_DETAILS', 'TherapyDetails', 'LONGVARCHAR', false, null, null);
		$this->addColumn('THERAPY_IMPACT', 'TherapyImpact', 'LONGVARCHAR', false, null, null);
		$this->addColumn('FUNDAMENTALS', 'Fundamentals', 'INTEGER', false, null, null);
		$this->addColumn('INTERMEDIATE_CURRICULUM', 'IntermediateCurriculum', 'INTEGER', false, null, null);
		$this->addColumn('CERTIFICATION', 'Certification', 'INTEGER', false, null, null);
		$this->addColumn('QUEST', 'Quest', 'INTEGER', false, null, null);
		$this->addColumn('ICC_CURRICULUM', 'IccCurriculum', 'INTEGER', false, null, null);
		$this->addColumn('HAVE_A_COACH', 'HaveACoach', 'VARCHAR', false, 10, null);
		$this->addColumn('COACHING_IMPACT', 'CoachingImpact', 'LONGVARCHAR', false, null, null);
		$this->addColumn('RELIGIOUS_AFFILIATIONS', 'ReligiousAffiliations', 'LONGVARCHAR', false, null, null);
		$this->addColumn('RELIGIOUS_INFLUENCES', 'ReligiousInfluences', 'LONGVARCHAR', false, null, null);
		$this->addColumn('GROWTH_EXPERIENCES', 'GrowthExperiences', 'LONGVARCHAR', false, null, null);
		$this->addColumn('IMPACT_AS_A_LEADER', 'ImpactAsALeader', 'LONGVARCHAR', false, null, null);
		$this->addColumn('CHALLENGE', 'Challenge', 'LONGVARCHAR', false, null, null);
		$this->addColumn('WHY_THIS_PROGRAM', 'WhyThisProgram', 'LONGVARCHAR', false, null, null);
		$this->addColumn('PLAY_LEVEL', 'PlayLevel', 'VARCHAR', false, 50, null);
		$this->addColumn('WHAT_WOULD_IT_TAKE', 'WhatWouldItTake', 'LONGVARCHAR', false, null, null);
		$this->addColumn('BRING_YOURSELF_BACK', 'BringYourselfBack', 'LONGVARCHAR', false, null, null);
		$this->addColumn('GOING_THE_DISTANCE', 'GoingTheDistance', 'LONGVARCHAR', false, null, null);
		$this->addColumn('I_WAS_BORN_TO', 'IWasBornTo', 'LONGVARCHAR', false, null, null);
		$this->addColumn('COMMENTS', 'Comments', 'LONGVARCHAR', false, null, null);
		$this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null, null);
		$this->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', false, null, null);
		$this->addColumn('EXTRA1', 'Extra1', 'LONGVARCHAR', false, null, null);
		$this->addColumn('EXTRA2', 'Extra2', 'LONGVARCHAR', false, null, null);
		$this->addColumn('EXTRA3', 'Extra3', 'LONGVARCHAR', false, null, null);
		$this->addColumn('EXTRA4', 'Extra4', 'LONGVARCHAR', false, null, null);
		$this->addColumn('EXTRA5', 'Extra5', 'LONGVARCHAR', false, null, null);
		$this->addColumn('EXTRA6', 'Extra6', 'LONGVARCHAR', false, null, null);
		$this->addColumn('EXTRA7', 'Extra7', 'LONGVARCHAR', false, null, null);
		$this->addColumn('EXTRA8', 'Extra8', 'LONGVARCHAR', false, null, null);
		$this->addColumn('EXTRA9', 'Extra9', 'LONGVARCHAR', false, null, null);
		$this->addColumn('EXTRA10', 'Extra10', 'LONGVARCHAR', false, null, null);
		$this->addColumn('EXTRA11', 'Extra11', 'LONGVARCHAR', false, null, null);
		$this->addColumn('EXTRA12', 'Extra12', 'LONGVARCHAR', false, null, null);
		$this->addColumn('EXTRA13', 'Extra13', 'LONGVARCHAR', false, null, null);
		$this->addColumn('EXTRA14', 'Extra14', 'LONGVARCHAR', false, null, null);
		$this->addColumn('EXTRA15', 'Extra15', 'LONGVARCHAR', false, null, null);
		$this->addColumn('EXTRA16', 'Extra16', 'LONGVARCHAR', false, null, null);
		$this->addColumn('EXTRA17', 'Extra17', 'LONGVARCHAR', false, null, null);
		$this->addColumn('EXTRA18', 'Extra18', 'LONGVARCHAR', false, null, null);
		$this->addColumn('EXTRA19', 'Extra19', 'LONGVARCHAR', false, null, null);
		$this->addColumn('EXTRA20', 'Extra20', 'LONGVARCHAR', false, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('Profile', 'Profile', RelationMap::MANY_TO_ONE, array('profile_id' => 'id', ), 'CASCADE', null);
	} // buildRelations()

	/**
	 * 
	 * Gets the list of behaviors registered for this table
	 * 
	 * @return array Associative array (name => parameters) of behaviors
	 */
	public function getBehaviors()
	{
		return array(
			'symfony' => array('form' => 'true', 'filter' => 'true', ),
			'symfony_behaviors' => array(),
			'symfony_timestampable' => array('create_column' => 'created_at', 'update_column' => 'updated_at', ),
		);
	} // getBehaviors()

} // ProgramQuestionnaireTableMap
