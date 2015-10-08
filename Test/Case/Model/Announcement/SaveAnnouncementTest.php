<?php
/**
 * Announcement::saveAnnouncement()のテスト
 *
 * @property Announcement $Announcement
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('WorkflowSaveTest', 'Workflow.TestSuite');

/**
 * Announcement::saveAnnouncement()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Announcements\Test\Case\Model\Announcement
 */
class AnnouncementSaveAnnouncementTest extends WorkflowSaveTest {

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
		'plugin.announcements.workflow_comment4announcements',
	);

/**
 * Model name
 *
 * @var array
 */
	public $_modelName = 'Announcement';

/**
 * Method name
 *
 * @var array
 */
	public $_methodName = 'saveAnnouncement';

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
			'room_id' => '1',
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
 * SaveのDataProvider
 *
 * ### 戻り値
 *  - data 登録データ
 *
 * @return void
 */
	public function dataProviderSave() {
		return array(
			array($this->__data, 'Announcement', 'saveAnnouncement'),
		);
	}

/**
 * SaveのExceptionErrorのDataProvider
 *
 * ### 戻り値
 *  - data 登録データ
 *  - mockModel Mockのモデル
 *  - mockMethod Mockのメソッド
 *
 * @return void
 */
	public function dataProviderSaveOnExceptionError() {
		return array(
			array($this->__data, 'Announcements.Announcement', 'save'),
		);
	}

/**
 * SaveのValidationErrorのDataProvider
 *
 * ### 戻り値
 *  - data 登録データ
 *  - mockModel Mockのモデル
 *
 * @return void
 */
	public function dataProviderSaveOnValidationError() {
		return array(
			array($this->__data, 'Announcements.Announcement'),
		);
	}

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
