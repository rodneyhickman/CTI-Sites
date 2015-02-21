<?php


/**
 * This class defines the structure of the 'event_routine' table.
 *
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * Fri Mar 18 23:28:35 2011
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class EventRoutineTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.EventRoutineTableMap';

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
		$this->setName('event_routine');
		$this->setPhpName('EventRoutine');
		$this->setClassname('EventRoutine');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
		$this->addColumn('EVENT_NAME', 'EventName', 'VARCHAR', false, 30, null);
		$this->addColumn('ACTION_ROUTINE', 'ActionRoutine', 'VARCHAR', false, 50, null);
		$this->addColumn('NEXT_DAY_TO_RUN', 'NextDayToRun', 'DATE', false, null, null);
		$this->addColumn('NEXT_TIME_TO_RUN', 'NextTimeToRun', 'TIME', false, null, null);
		$this->addColumn('LAST_RUN', 'LastRun', 'TIMESTAMP', false, null, null);
		$this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null, null);
		$this->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', false, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
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

} // EventRoutineTableMap