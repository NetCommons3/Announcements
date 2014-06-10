<?php
/**
 * AnnouncementDatum Test Case
 *
 * @author   Takako Miyagawa <nekoget@gmail.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('AnnouncementDatum', 'Announcements.Model');

/**
 * Summary for AnnouncementDatum Test Case
 */
class AnnouncementDatumTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'announcement_datum',
		'announcement',
		'announcement_frame'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->AnnouncementDatum = ClassRegistry::init('Announcements.AnnouncementDatum');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->AnnouncementDatum);
		parent::tearDown();
	}

/**
 * saveData
 *
 * @return void
 */
	public function testSaveData() {
		$data = array();
		$data['AnnouncementDatum']['content'] = "test";
		$data['AnnouncementDatum']['frameId'] = 1;
		$data['AnnouncementDatum']['blockId'] = 0;
		$data['AnnouncementDatum']['type']    = "Draft";
		$data['AnnouncementDatum']['langId'] = 2;
		$data['AnnouncementDatum']['id'] = 0;
		$frameId = 1;
		$userId = 1;
		$blockId = 1;
		$dataId = 0;
		$isAjax = false;
		$rtn = $this->AnnouncementDatum->saveData($data, $frameId, $blockId, $dataId, $userId , $isAjax);
		$this->assertTrue(is_numeric($rtn['AnnouncementDatum']['id']));
		$this->assertTextEquals($rtn['AnnouncementDatum']['status_id'] , 3);
		$this->assertTextEquals($rtn['AnnouncementDatum']['content'] , "test");
	}

/**
 * saveData
 *
 * @return void
 */
	public function testSaveDataIsAjax() {
		$data = array();
		$data['AnnouncementDatum']['content'] = rawurlencode("test"); //URLエンコード
		$data['AnnouncementDatum']['frameId'] = 1;
		$data['AnnouncementDatum']['blockId'] = 0;
		$data['AnnouncementDatum']['type']    = "Draft";
		$data['AnnouncementDatum']['langId'] = 2;
		$data['AnnouncementDatum']['id'] = 0;
		$frameId = 1;
		$userId = 1;
		$blockId = 1;
		$dataId = 0;
		$isAjax = true;
		$rtn = $this->AnnouncementDatum->saveData($data, $frameId, $blockId, $dataId, $userId , $isAjax);
		$this->assertTrue(is_numeric($rtn['AnnouncementDatum']['id']));
		$this->assertTextEquals($rtn['AnnouncementDatum']['status_id'] , 3);
		$this->assertTextEquals($rtn['AnnouncementDatum']['content'] , "test");
	}

	public function testSaveData_NewBlock() {
		$data = array();
		$data['AnnouncementDatum']['content'] = rawurlencode("test"); //URLエンコード
		$data['AnnouncementDatum']['blockId'] = 100;
		$data['AnnouncementDatum']['type']    = "Draft";
		$data['AnnouncementDatum']['langId'] = 2;
		$data['AnnouncementDatum']['id'] = 0;
		$frameId = 2;
		$userId = 1;
		$blockId = 1;
		$dataId = 0;
		$isAjax = true;
		$rtn = $this->AnnouncementDatum->saveData($data, $frameId, $blockId, $dataId, $userId , $isAjax);
		$this->assertTrue(is_numeric($rtn['AnnouncementDatum']['id']));
		$this->assertTextEquals($rtn['AnnouncementDatum']['status_id'] , 3);
		$this->assertTextEquals($rtn['AnnouncementDatum']['content'] , "test");
	}



	/**
	 * saveData
	 *
	 * @return void
	 */
	public function testGetData_IsSetting(){
		$blockId = 1;
		$lang = 1;
		$isSetting = 1;
		//セッティングモードなので下書きを含む最新がとれる
		$rtn = $this->AnnouncementDatum->getData($blockId, $lang, $isSetting);
		$this->assertTextEquals($rtn['AnnouncementDatum']['id'] , 1);
	}

/**
 * saveData
 *
 * @return void
 */
	public function testGetData(){
		$blockId = 1;
		$lang = 1;
		$isSetting = 0;
		$rtn = $this->AnnouncementDatum->getData($blockId, $lang, $isSetting);
		//セッティングモードOFFなので公開情報がとれる
		//$this->assertTextEquals($rtn['AnnouncementDatum']['id'] , 1);
	}

}