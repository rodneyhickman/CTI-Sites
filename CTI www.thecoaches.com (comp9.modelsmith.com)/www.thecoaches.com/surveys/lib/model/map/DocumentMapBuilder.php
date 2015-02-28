<?php


/**
 * This class adds structure of 'document' table to 'propel' DatabaseMap object.
 *
 *
 * This class was autogenerated by Propel 1.3.0-dev on:
 *
 * Fri May 11 15:57:11 2012
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class DocumentMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.DocumentMapBuilder';

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
		$this->dbMap = Propel::getDatabaseMap(DocumentPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(DocumentPeer::TABLE_NAME);
		$tMap->setPhpName('Document');
		$tMap->setClassname('Document');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'INTEGER', true, null);

		$tMap->addForeignKey('PROFILE_ID', 'ProfileId', 'INTEGER', 'profile', 'ID', false, null);

		$tMap->addColumn('DESCRIPTION', 'Description', 'LONGVARCHAR', false, null);

		$tMap->addColumn('URL', 'Url', 'LONGVARCHAR', false, null);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null);

		$tMap->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', false, null);

		$tMap->addColumn('EXTRA1', 'Extra1', 'LONGVARCHAR', false, null);

		$tMap->addColumn('EXTRA2', 'Extra2', 'LONGVARCHAR', false, null);

		$tMap->addColumn('EXTRA3', 'Extra3', 'LONGVARCHAR', false, null);

		$tMap->addColumn('EXTRA4', 'Extra4', 'LONGVARCHAR', false, null);

		$tMap->addColumn('EXTRA5', 'Extra5', 'LONGVARCHAR', false, null);

		$tMap->addColumn('EXTRA6', 'Extra6', 'LONGVARCHAR', false, null);

		$tMap->addColumn('EXTRA7', 'Extra7', 'LONGVARCHAR', false, null);

		$tMap->addColumn('EXTRA8', 'Extra8', 'LONGVARCHAR', false, null);

		$tMap->addColumn('EXTRA9', 'Extra9', 'LONGVARCHAR', false, null);

		$tMap->addColumn('EXTRA10', 'Extra10', 'LONGVARCHAR', false, null);

		$tMap->addColumn('EXTRA11', 'Extra11', 'LONGVARCHAR', false, null);

		$tMap->addColumn('EXTRA12', 'Extra12', 'LONGVARCHAR', false, null);

		$tMap->addColumn('EXTRA13', 'Extra13', 'LONGVARCHAR', false, null);

		$tMap->addColumn('EXTRA14', 'Extra14', 'LONGVARCHAR', false, null);

		$tMap->addColumn('EXTRA15', 'Extra15', 'LONGVARCHAR', false, null);

		$tMap->addColumn('EXTRA16', 'Extra16', 'LONGVARCHAR', false, null);

		$tMap->addColumn('EXTRA17', 'Extra17', 'LONGVARCHAR', false, null);

		$tMap->addColumn('EXTRA18', 'Extra18', 'LONGVARCHAR', false, null);

		$tMap->addColumn('EXTRA19', 'Extra19', 'LONGVARCHAR', false, null);

		$tMap->addColumn('EXTRA20', 'Extra20', 'LONGVARCHAR', false, null);

	} // doBuild()

} // DocumentMapBuilder
