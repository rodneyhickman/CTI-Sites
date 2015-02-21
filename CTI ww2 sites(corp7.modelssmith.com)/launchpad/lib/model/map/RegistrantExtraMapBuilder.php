<?php


/**
 * This class adds structure of 'registrant_extra' table to 'propel' DatabaseMap object.
 *
 *
 * This class was autogenerated by Propel 1.3.0-dev on:
 *
 * Fri Sep 11 14:33:29 2009
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class RegistrantExtraMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.RegistrantExtraMapBuilder';

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
		$this->dbMap = Propel::getDatabaseMap(RegistrantExtraPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(RegistrantExtraPeer::TABLE_NAME);
		$tMap->setPhpName('RegistrantExtra');
		$tMap->setClassname('RegistrantExtra');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'INTEGER', true, null);

		$tMap->addForeignKey('REGISTRANT_ID', 'RegistrantId', 'INTEGER', 'registrant', 'ID', false, null);

		$tMap->addColumn('FIELD_NAME', 'FieldName', 'VARCHAR', false, 50);

		$tMap->addColumn('FIELD_ORDER', 'FieldOrder', 'INTEGER', false, null);

		$tMap->addColumn('FIELD_DATA', 'FieldData', 'VARCHAR', false, 50);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null);

		$tMap->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', false, null);

	} // doBuild()

} // RegistrantExtraMapBuilder