<?php
/**
 * 多言語化対応
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsMigration', 'NetCommons.Config/Migration');

/**
 * 多言語化対応
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Announcements\Config\Migration
 */
class M17n extends NetCommonsMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'm17n';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'create_field' => array(
				'announcements' => array(
					'is_origin' => array('type' => 'boolean', 'null' => false, 'default' => '1', 'after' => 'is_latest'),
					'is_translation' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'after' => 'is_origin'),
				),
			),
		),
		'down' => array(
			'drop_field' => array(
				'announcements' => array('is_origin', 'is_translation'),
			),
		),
	);

/**
 * Before migration callback
 *
 * @param string $direction Direction of migration process (up or down)
 * @return bool Should process continue
 */
	public function before($direction) {
		return true;
	}

/**
 * After migration callback
 *
 * @param string $direction Direction of migration process (up or down)
 * @return bool Should process continue
 */
	public function after($direction) {
		return true;
	}
}