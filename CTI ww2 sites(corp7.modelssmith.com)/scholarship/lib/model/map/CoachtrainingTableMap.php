<?php


/**
 * This class defines the structure of the 'coachtraining' table.
 *
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * Thu May 23 17:45:37 2013
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class CoachtrainingTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.CoachtrainingTableMap';

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
		$this->setName('coachtraining');
		$this->setPhpName('Coachtraining');
		$this->setClassname('Coachtraining');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
		$this->addForeignKey('PROFILE_ID', 'ProfileId', 'INTEGER', 'profile', 'ID', false, null, null);
		$this->addColumn('PROGRAM_PREFERENCE', 'ProgramPreference', 'LONGVARCHAR', false, null, null);
		$this->addColumn('CORE_PREFERRED_DATE1', 'CorePreferredDate1', 'LONGVARCHAR', false, null, null);
		$this->addColumn('CORE_PREFERRED_DATE2', 'CorePreferredDate2', 'LONGVARCHAR', false, null, null);
		$this->addColumn('CORE_PREFERRED_DATE3', 'CorePreferredDate3', 'LONGVARCHAR', false, null, null);
		$this->addColumn('CERT_PREFERRED_DATE1', 'CertPreferredDate1', 'LONGVARCHAR', false, null, null);
		$this->addColumn('CERT_PREFERRED_DATE2', 'CertPreferredDate2', 'LONGVARCHAR', false, null, null);
		$this->addColumn('CERT_PREFERRED_DATE3', 'CertPreferredDate3', 'LONGVARCHAR', false, null, null);
		$this->addColumn('WHAT_CHOOSE', 'WhatChoose', 'LONGVARCHAR', false, null, null);
		$this->addColumn('FUNDAMENTALS_EXP', 'FundamentalsExp', 'LONGVARCHAR', false, null, null);
		$this->addColumn('YOUR_VISION', 'YourVision', 'LONGVARCHAR', false, null, null);
		$this->addColumn('HOW_SUPPORT', 'HowSupport', 'LONGVARCHAR', false, null, null);
		$this->addColumn('WHY_APPLYING', 'WhyApplying', 'LONGVARCHAR', false, null, null);
		$this->addColumn('WHAT_SIZE', 'WhatSize', 'LONGVARCHAR', false, null, null);
		$this->addColumn('BACKGROUND', 'Background', 'LONGVARCHAR', false, null, null);
		$this->addColumn('ANYTHING_ELSE', 'AnythingElse', 'LONGVARCHAR', false, null, null);
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

} // CoachtrainingTableMap
