<?php
/**
 * AnnouncementDatum Test Case
 *
* @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
* @link     http://www.netcommons.org NetCommons Project
* @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('AnnouncementDatum', 'Model');

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
		'app.announcement_datum'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->AnnouncementDatum = ClassRegistry::init('AnnouncementDatum');
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

}
