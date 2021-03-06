<?php
/**
 * Announcement::deleteAnnouncement()のテスト
 *
 * @property Announcement $Announcement
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('WorkflowDeleteTest', 'Workflow.TestSuite');

/**
 * Announcement::deleteAnnouncement()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Announcements\Test\Case\Model\Announcement
 */
class AnnouncementDeleteAnnouncementTest extends WorkflowDeleteTest {

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
	protected $_methodName = 'deleteAnnouncement';

/**
 * data
 *
 * @var array
 */
	private $__data = array(
		'Block' => array(
			'id' => '2',
			'key' => 'block_1',
		),
		'Announcement' => array(
			'key' => 'announcement_1',
		),
	);

/**
 * DeleteのDataProvider
 *
 * ### 戻り値
 *  - data: 削除データ
 *  - associationModels: 削除確認の関連モデル array(model => conditions)
 *
 * @return void
 */
	public function dataProviderDelete() {
		return array(
			array($this->__data),
		);
	}

/**
 * ExceptionErrorのDataProvider
 *
 * ### 戻り値
 *  - data: 登録データ
 *  - mockModel: Mockのモデル
 *  - mockMethod: Mockのメソッド
 *
 * @return void
 */
	public function dataProviderDeleteOnExceptionError() {
		return array(
			array($this->__data, 'Announcements.Announcement', 'deleteAll'),
		);
	}

}
