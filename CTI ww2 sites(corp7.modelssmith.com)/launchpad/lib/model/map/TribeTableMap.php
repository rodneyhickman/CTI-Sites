<?php


/**
 * This class defines the structure of the 'tribe' table.
 *
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * Fri Nov 11 20:46:57 2011
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class TribeTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.TribeTableMap';

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
		$this->setName('tribe');
		$this->setPhpName('Tribe');
		$this->setClassname('Tribe');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
		$this->addColumn('NAME', 'Name', 'LONGVARCHAR', false, null, null);
		$this->addColumn('LOCATION', 'Location', 'LONGVARCHAR', false, null, null);
		$this->addColumn('RETREAT1_DATE', 'Retreat1Date', 'DATE', false, null, null);
		$this->addColumn('RETREAT2_DATE', 'Retreat2Date', 'DATE', false, null, null);
		$this->addColumn('RETREAT3_DATE', 'Retreat3Date', 'DATE', false, null, null);
		$this->addColumn('RETREAT4_DATE', 'Retreat4Date', 'DATE', false, null, null);
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
    $this->addRelation('TribeParticipant', 'TribeParticipant', RelationMap::ONE_TO_MANY, array('id' => 'tribe_id', ), 'CASCADE', null);
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

} // TribeTableMap
