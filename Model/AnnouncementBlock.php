<?php
/**
 * AnnouncementBlock Model
 *
 * @author   Ryuji Masukawa <masukawa@nii.ac.jp>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('AnnouncementsAppModel', 'Announcements.Model');

/**
 * Announcement Model
 */
class AnnouncementBlock extends AnnouncementsAppModel {

/**
 * hasMany
 *
 * @var array
 */
	public $hasMany = array(
		'AnnouncementBlocksPart' => array(
			'className' => 'Announcements.AnnouncementBlocksPart',
			'order' => 'AnnouncementBlocksPart.part_id ASC',
			'dependent' => true,
		)
	);

/**
 * construct
 * @param boolean|integer|string|array $id Set this ID for this model on startup,
 * can also be an array of options, see above.
 * @param string $table Name of database table to use.
 * @param string $ds DataSource connection name.
 * @return  void
 */
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);

		$this->validate = array(
			'block_id' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					'required' => true,
					'allowEmpty' => false,
					'message' => __('The input must be a number.')
				)
			),
			'send_mail' => array(
				'boolean' => array(
					'rule' => array('boolean'),
					'last' => true,
					'required' => true,
					'message' => __('The input must be a boolean.')
				)
			),
			// mail_subject
			// mail_body
		);
	}

/**
 * 初期データ取得
 *
 * @param integer $blockId
 * @return array
 * @access public
 */
	public function findByBlockIdOrDefault($blockId) {
		$data = $this->findByBlockId($blockId);
		if (empty($data[$this->alias])) {
			$data = $this->create();
			$data[$this->alias]['id'] = 0;
			$data[$this->alias]['block_id'] = $blockId;
			$AnnouncementBlocksPart = ClassRegistry::init('Announcements.AnnouncementBlocksPart');
			$data = array_merge($data, $AnnouncementBlocksPart->findByAnnouncementBlockIdOrDefault(0));
		}
		return $data;
	}

/**
 * 会員のblockID, partIDから編集権限等を含めて取得
 *
 * @param integer $blockId
 * @param integer $partId
 * @return array
 * @access public
 */
	public function findByAuthOrDefault($blockId, $partId) {
		$data = $this->find('first', array(
			'fields' => array('AnnouncementBlock.*', 'AnnouncementBlocksPart.*'),
			'recursive' => -1,
			'conditions' => array('AnnouncementBlock.block_id' => $blockId),
			'joins' => array(
				array(
					"type" => "INNER",
					"table" => "announcement_blocks_parts",
					"alias" => "AnnouncementBlocksPart",
					"conditions" => array(
						'AnnouncementBlocksPart.announcement_block_id = AnnouncementBlock.id',
						'AnnouncementBlocksPart.part_id' => $partId
					)
				),
			),
		));

		if (empty($data[$this->alias])) {
			$data = $this->create();
			$data[$this->alias]['id'] = 0;
			$data[$this->alias]['block_id'] = $blockId;
			$AnnouncementBlocksPart = ClassRegistry::init('Announcements.AnnouncementBlocksPart');
			$data = array_merge($data, $AnnouncementBlocksPart->findByKeysOrDefault(0, $partId));
		}
		return $data;
	}

/**
 * リクエストデータに既存IDマージ処理
 *
 * @param  array $requestData
 * @param  array $announcementBlock
 * @return array
 * @access public
 */
	public function mergeRequestId($requestData, $announcementBlock) {
		$requestData[$this->alias]['id'] = $announcementBlock[$this->alias]['id'];
		$requestData[$this->alias]['block_id'] = $announcementBlock[$this->alias]['block_id'];

		$AnnouncementBlocksPart = ClassRegistry::init('Announcements.AnnouncementBlocksPart');
		if (!empty($requestData[$AnnouncementBlocksPart->alias])) {
			foreach ($requestData[$AnnouncementBlocksPart->alias] as $key => $value) {
				if (!isset($announcementBlock[$AnnouncementBlocksPart->alias][$key])) {
					unset($requestData[$AnnouncementBlocksPart->alias][$key]);
					continue;
				}

				$requestData[$AnnouncementBlocksPart->alias][$key]['id'] = $announcementBlock[$AnnouncementBlocksPart->alias][$key]['id'];
				$requestData[$AnnouncementBlocksPart->alias][$key]['announcement_block_id'] = $announcementBlock[$AnnouncementBlocksPart->alias][$key]['announcement_block_id'];
				$requestData[$AnnouncementBlocksPart->alias][$key]['part_id'] = $announcementBlock[$AnnouncementBlocksPart->alias][$key]['part_id'];
				if (!isset($requestData[$AnnouncementBlocksPart->alias][$key]['can_edit_content'])) {
					$requestData[$AnnouncementBlocksPart->alias][$key]['can_edit_content'] = false;
				}
				if (!isset($requestData[$AnnouncementBlocksPart->alias][$key]['can_publish_content'])) {
					$requestData[$AnnouncementBlocksPart->alias][$key]['can_publish_content'] = false;
				}
				if (!isset($requestData[$AnnouncementBlocksPart->alias][$key]['can_send_mail'])) {
					$requestData[$AnnouncementBlocksPart->alias][$key]['can_send_mail'] = false;
				}
			}
		}

		return $requestData;
	}

}
