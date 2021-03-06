<?php
/**
 * Announcement::validates()のテスト
 *
 * @property Announcement $Announcement
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsValidateTest', 'NetCommons.TestSuite');

/**
 * Announcement::validates()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Announcements\Test\Case\Model\Announcement
 */
class AnnouncementValidateTest extends NetCommonsValidateTest {

/**
 * Plugin name
 *
 * @var array
 */
	public $plugin = 'announcements';

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.announcements.announcement',
		'plugin.announcements.block_setting_for_announcement',
		'plugin.workflow.workflow_comment',
	);

/**
 * Model name
 *
 * @var array
 */
	protected $_modelName = 'Announcement';

/**
 * Method name
 *
 * @var array
 */
	protected $_methodName = 'validates';

/**
 * data
 *
 * @var array
 */
	private $__data = array(
		'Frame' => array(
			'id' => '6'
		),
		'Block' => array(
			'id' => '2',
			'language_id' => '2',
			'room_id' => '2',
			'key' => 'block_1',
			'plugin_key' => 'announcements',
		),
		'Announcement' => array(
			'id' => '2',
			'language_id' => '2',
			'block_id' => '2',
			'key' => 'announcement_1',
			'status' => WorkflowComponent::STATUS_PUBLISHED,
			'content' => 'Announcement save test'
		),
		'WorkflowComment' => array(
			'comment' => 'WorkflowComment save test'
		),
	);

/**
 * ValidationErrorのDataProvider
 *
 * ### 戻り値
 *  - field フィールド名
 *  - value セットする値
 *  - message エラーメッセージ
 *  - overwrite 上書きするデータ
 *
 * @return void
 */
	public function dataProviderValidationError() {
		return array(
			array($this->__data, 'content', '',
				sprintf(__d('net_commons', 'Please input %s.'), __d('announcements', 'Content'))),
			array($this->__data, 'block_id', 'aaa',
				__d('net_commons', 'Invalid request.')),
		);
	}

}
