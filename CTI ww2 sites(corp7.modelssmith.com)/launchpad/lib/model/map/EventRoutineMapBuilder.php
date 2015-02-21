<?php


/**
 * This class adds structure of 'event_routine' table to 'propel' DatabaseMap object.
 *
 *
 * This class was autogenerated by Propel 1.3.0-dev on:
 *
 * Fri Sep 11 14:33:28 2009
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class EventRoutineMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.EventRoutineMapBuilder';

	/**
	 * The database map.
	 */
	private $dbMap;

	/**
	 * Tells us if this DatabaseMapBuilder is built so that we
	 * don't have to re-build it every time.
	 *
	 * @return     boolean true if this DatabaseMapBuilder is built, false otherwise.
	 */
	public function isBuilt()
	{
		return ($this->dbMap !== null);
	}

	/**
	 * Gets the databasemap this map builder built.
	 *
	 * @return     the databasemap
	 */
	public function getDatabaseMap()
	{
		return $this->dbMap;
	}

	/**
	 * The doBuild() method builds the DatabaseMap
	 *
	 * @return     void
	 * @throws     PropelException
	 */
	public function doBuild()
	{
		$this->dbMap = Propel::getDatabaseMap(EventRoutinePeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(EventRoutinePeer::TABLE_NAME);
		$tMap->setPhpName('EventRoutine');
		$tMap->setClassname('EventRoutine');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'INTEGER', true, null);

		$tMap->addColumn('EVENT_NAME', 'EventName', 'VARCHAR', false, 30);

		$tMap->addColumn('ACTION_ROUTINE', 'ActionRoutine', 'VARCHAR', false, 50);

		$tMap->addColumn('NEXT_DAY_TO_RUN', 'NextDayToRun', 'DATE', false, null);

		$tMap->addColumn('NEXT_TIME_TO_RUN', 'NextTimeToRun', 'TIME', false, null);

		$tMap->addColumn('LAST_RUN', 'LastRun', 'TIMESTAMP', false, null);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null);

		$tMap->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', false, null);

	} // doBuild()

} // EventRoutineMapBuilder