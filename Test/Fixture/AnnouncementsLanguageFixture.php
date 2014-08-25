<?php
/**
 * LanguageFixture
 *
 * @author   Takako Miyagawa <nekoget@gmail.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

/**
 * Summary for LanguageFixture
 */
class AnnouncementsLanguageFixture extends CakeTestFixture {

/**
 * table
 *
 * @var string
 */
	public $table = 'languages';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'code' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 3, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'weight' => array('type' => 'integer', 'null' => true, 'default' => null),
		'is_active' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'created_user_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified_user_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => '1',
			'code' => 'eng',
			'weight' => '1',
			'is_active' => 1,
			'created_user_id' => null,
			'created' => '2014-08-24 23:35:05',
			'modified_user_id' => null,
			'modified' => '2014-08-24 23:35:05'
		),
		array(
			'id' => '2',
			'code' => 'jpn',
			'weight' => '2',
			'is_active' => 1,
			'created_user_id' => null,
			'created' => '2014-08-24 23:35:05',
			'modified_user_id' => null,
			'modified' => '2014-08-24 23:35:05'
		),
	);

}
