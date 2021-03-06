<?php
/**
 * AnnouncementsController Test Case
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('WorkflowControllerViewTest', 'Workflow.TestSuite');

/**
 * AnnouncementsController Test Case
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Announcements\Test\Case\Controller
 */
class AnnouncementsControllerViewTest extends WorkflowControllerViewTest {

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
 * Plugin name
 *
 * @var array
 */
	public $plugin = 'announcements';

/**
 * Controller name
 *
 * @var string
 */
	protected $_controller = 'announcements';

/**
 * viewアクションのテスト用DataProvider
 *
 * ### 戻り値
 *  - urlOptions: URLオプション
 *  - assert: テストの期待値
 *  - exception: Exception
 *  - return: testActionの実行後の結果
 *
 * @return array
 */
	public function dataProviderView() {
		$results = array();

		//ログインなし
		//--コンテンツあり
		$results[0] = array(
			'urlOptions' => array('frame_id' => '6', 'block_id' => '2', 'key' => null),
			'assert' => array('method' => 'assertNotEmpty'),
		);
		$results[1] = Hash::merge($results[0], array(
			'assert' => array('method' => 'assertActionLink', 'action' => 'edit', 'linkExist' => false, 'url' => array()),
		));
		//--コンテンツなし
		$results[2] = array(
			'urlOptions' => array('frame_id' => '14', 'block_id' => null, 'key' => null),
			'assert' => array('method' => 'assertEquals', 'expected' => 'emptyRender'),
			'exception' => null, 'return' => 'viewFile'
		);

		return $results;
	}

/**
 * viewアクションのテスト
 *
 * @return void
 */
	public function testViewJson() {
		$result = $this->dataProviderView()[0];
		$this->_testGetAction('/announcements/announcements/view/2.json?frame_id=6', Hash::get($result, 'assert'), null, 'json');
	}

/**
 * viewアクションのテスト(作成権限のみ)用DataProvider
 *
 * ### 戻り値
 *  - urlOptions: URLオプション
 *  - assert: テストの期待値
 *  - exception: Exception
 *  - return: testActionの実行後の結果
 *
 * @return array
 */
	public function dataProviderViewByCreatable() {
		$results = array();

		//作成権限のみ
		$results[0] = array(
			'urlOptions' => array('frame_id' => '6', 'block_id' => '2', 'key' => null),
			'assert' => array('method' => 'assertNotEmpty'),
		);
		$results[1] = Hash::merge($results[0], array(
			'assert' => array('method' => 'assertActionLink', 'action' => 'edit', 'linkExist' => false, 'url' => array()),
		));
		//--コンテンツなし
		$results[2] = array(
			'urlOptions' => array('frame_id' => '14', 'block_id' => null, 'key' => null),
			'assert' => array('method' => 'assertEquals', 'expected' => 'emptyRender'),
			'exception' => null, 'return' => 'viewFile'
		);

		return $results;
	}

/**
 * viewアクションのテスト用DataProvider
 *
 * ### 戻り値
 *  - urlOptions: URLオプション
 *  - assert: テストの期待値
 *  - exception: Exception
 *  - return: testActionの実行後の結果
 *
 * @return array
 */
	public function dataProviderViewByEditable() {
		$results = array();

		//編集権限あり
		//--コンテンツあり
		$results[0] = array(
			'urlOptions' => array('frame_id' => '6', 'block_id' => '2', 'key' => null),
			'assert' => array('method' => 'assertNotEmpty'),
		);
		$results[1] = Hash::merge($results[0], array(
			'assert' => array('method' => 'assertActionLink', 'action' => 'edit', 'linkExist' => true, 'url' => array()),
		));
		//--コンテンツなし
		$results[2] = array(
			'urlOptions' => array('frame_id' => '14', 'block_id' => null, 'key' => null),
			'assert' => array('method' => 'assertNotEmpty'),
		);
		$results[3] = Hash::merge($results[2], array(
			'assert' => array('method' => 'assertActionLink', 'action' => 'edit', 'linkExist' => true, 'url' => array()),
		));
		//フレームID指定なしテスト
		$results[4] = array(
			'urlOptions' => array('frame_id' => null, 'block_id' => '2', 'key' => null),
			'assert' => array('method' => 'assertNotEmpty'),
		);
		$results[5] = Hash::merge($results[4], array(
			'assert' => array('method' => 'assertActionLink', 'action' => 'edit', 'linkExist' => true, 'url' => array()),
		));

		return $results;
	}

}
