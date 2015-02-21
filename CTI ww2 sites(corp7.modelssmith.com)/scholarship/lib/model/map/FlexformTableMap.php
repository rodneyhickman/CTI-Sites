<?php


/**
 * This class defines the structure of the 'flexform' table.
 *
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * Thu May 23 17:45:42 2013
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class FlexformTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.FlexformTableMap';

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
		$this->setName('flexform');
		$this->setPhpName('Flexform');
		$this->setClassname('Flexform');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
		$this->addColumn('NAME', 'Name', 'LONGVARCHAR', false, null, null);
		$this->addColumn('TITLE', 'Title', 'LONGVARCHAR', false, null, null);
		$this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null, null);
		$this->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', false, null, null);
		$this->addColumn('EXTRA1', 'Extra1', 'LONGVARCHAR', false, null, null);
		$this->addColumn('EXTRA2', 'Extra2', 'LONGVARCHAR', false, null, null);
		$this->addColumn('EXTRA3', 'Extra3', 'LONGVARCHAR', false, null, null);
		$this->addColumn('EXTRA4', 'Extra4', 'LONGVARCHAR', false, null, null);
		$this->addColumn('EXTRA5', 'Extra5', 'LONGVARCHAR', false, null, null);
		$this->addColumn('EXTRA6', 'Extra6', 'LONGVARCHAR', false, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('FlexformQuestion', 'FlexformQuestion', RelationMap::ONE_TO_MANY, array('id' => 'flexform_id', ), 'CASCADE', null);
    $this->addRelation('FlexformSubmission', 'FlexformSubmission', RelationMap::ONE_TO_MANY, array('id' => 'flexform_id', ), 'SET NULL', null);
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

} // FlexformTableMap
