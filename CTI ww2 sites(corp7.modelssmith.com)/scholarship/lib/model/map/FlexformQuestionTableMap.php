<?php


/**
 * This class defines the structure of the 'flexform_question' table.
 *
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * Thu May 23 17:45:43 2013
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class FlexformQuestionTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.FlexformQuestionTableMap';

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
		$this->setName('flexform_question');
		$this->setPhpName('FlexformQuestion');
		$this->setClassname('FlexformQuestion');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
		$this->addForeignKey('FLEXFORM_ID', 'FlexformId', 'INTEGER', 'flexform', 'ID', false, null, null);
		$this->addColumn('TYPE', 'Type', 'VARCHAR', false, 20, null);
		$this->addColumn('NUMBER', 'Number', 'VARCHAR', false, 10, null);
		$this->addColumn('LABEL', 'Label', 'LONGVARCHAR', false, null, null);
		$this->addColumn('PARAM_NAME', 'ParamName', 'VARCHAR', false, 30, null);
		$this->addColumn('OPTIONS', 'Options', 'LONGVARCHAR', false, null, null);
		$this->addColumn('CSS_CLASS', 'CssClass', 'LONGVARCHAR', false, null, null);
		$this->addColumn('DISPLAY_ORDER', 'DisplayOrder', 'INTEGER', false, null, null);
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
    $this->addRelation('Flexform', 'Flexform', RelationMap::MANY_TO_ONE, array('flexform_id' => 'id', ), 'CASCADE', null);
    $this->addRelation('FlexformAnswer', 'FlexformAnswer', RelationMap::ONE_TO_MANY, array('id' => 'flexform_question_id', ), 'SET NULL', null);
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

} // FlexformQuestionTableMap
