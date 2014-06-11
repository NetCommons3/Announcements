<?php
/**
 * AnnouncementsController Test Case
 *
 * @author   Takako Miyagawa <nekoget@gmail.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('AppController', 'Controller');

/**
 * Summary for AnnouncementEditsController Test Case
 */
class AnnouncementsControllerTest extends ControllerTestCase {

/**
 * setUp
 *
 * @return   void
 */
	public function setUp() {
		parent::setUp();
	}

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.Session',
		'app.SiteSetting',
		'app.SiteSettingValue',
		'app.Page',
		'plugin.announcements.announcement_datum',
		'plugin.announcements.announcement',
		'plugin.announcements.announcement_frame'
	);

/**
 * index
 *
 * @return   void
 */
	public function testIndex() {
		$this->testAction('/announcements/announcements/index', array('method' => 'get'));
		$this->assertTextNotContains('ERROR', $this->view);
	}

/**
 * post
 *
 * @return   void
 */
	public function testPost() {
		$this->testAction('/announcements/announcements/post/Draft/1/1/0/', array('method' => 'get'));
		$this->assertTextNotContains('ERROR', $this->view);
	}

/**
 * put
 *
 * @return   void
 */
	public function testPut() {
		$this->testAction('/announcements/announcements/put/Draft/1/1/0/', array('method' => 'get'));
		$this->assertTextNotContains('ERROR', $this->view);
	}

/**
 * delete
 *
 * @return   void
 */
	public function testDelete() {
		$this->testAction('/announcements/announcements/delete/Draft/1/1/1/', array('method' => 'get'));
		$this->assertTextNotContains('ERROR', $this->view);
	}

/**
 * delete
 *
 * @return   void
 */
	public function testGet() {
		$this->testAction('/announcements/announcements/get/Draft/1/1/1/', array('method' => 'get'));
		$this->assertTextNotContains('ERROR', $this->view);
	}

/**
 * delete
 *
 * @return   void
 */
	public function testBlockSetting() {
		$this->testAction('/announcements/announcements/block_setting/1/', array('method' => 'get'));
		$this->assertTextNotContains('ERROR', $this->view);
	}

/**
 * get_edit_form
 *
 * @return   void
 */
	public function testGetEditForm() {
		$this->testAction('/announcements/announcements/get_edit_form/1/1', array('method' => 'get'));
		$this->assertTextNotContains('ERROR', $this->view);
	}
}
