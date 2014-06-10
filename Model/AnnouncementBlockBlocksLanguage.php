<?php
/**
 * AnnouncementBlockBlocksLanguage Model
 *
 * @author   Takako Miyagawa <nekoget@gmail.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

class AnnouncementBlockBlocksLanguage extends AppModel {

/**
 * table
 *
 * @var bool
 */
	public $useTable = 'blocks_language';

/**
 * name
 *
 * @var string
 */
	public $name = "AnnouncementBlockBlocksLanguage";

/**
 * __construct
 *
 * @param bool $id id
 * @param null $table db table
 * @param null $ds connection
 * @return void
 * @SuppressWarnings(PHPMD)
 */
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);
	}
}