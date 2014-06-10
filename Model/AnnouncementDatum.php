<?php
/**
 * AnnouncementDatum Model
 *
 * @author   Takako Miyagawa <nekoget@gmail.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('AppModel', 'Model');

/**
 * Summary for AnnouncementDatum Model
 */
class AnnouncementDatum extends AppModel {

/**
 * name
 *
 * @var string
 */
	public $name = 'AnnouncementDatum';

/**
 * table
 *
 * @var string
 */
	public $useTable = 'announcement_data';

/**
 * belongsTo
 *
 * @var string
 */
	public $belongsTo = 'Announcement';

/**
 * announcement_data.status_id 公開状態の設定値
 *
 * @var int
 */
	public $isPublish = 1;

/**
 * Blocks model object
 *
 * @var null
 */
	private $__Block = null;

/**
 * announcement model object
 *
 * @var null
 */
	private $__Announcement = null;

/**
 * announcement_blocks model object
 *
 * @var null
 */
	private $__AnnouncementBlock = null;

/**
 * frames model object
 *
 * @var null
 */
	private $__Frame = null;

/**
 * status type
 *
 * @var array
 */
	public $type = array(
		'Publish' => 1,
		'PublishRequest' => 2,
		'Draft' => 3
	);

/**
 * 最新のデータを取得する
 *
 * @param int $blockId  blocks.id
 * @param string $lang  language_id
 * @param null $isSetting セッティングモードの状態 trueならon
 * @return array
 */
	public function getData($blockId, $lang, $isSetting = null) {
		if (! $isSetting) {
			$this->getPublishData($blockId, $lang);
		}
		return $this->find('first', array(
			'conditions' => array(
				'Announcement.block_id' => $blockId,
				'AnnouncementDatum.language_id' => $lang,
			),
			'order' => 'AnnouncementDatum.id DESC',
		));
	}

/**
 * 最新の公開情報を取得する。
 *
 * @param int $blockId blocks.id
 * @param int $lang  language_id
 * @return array
 */
	public function getPublishData($blockId, $lang) {
		return $this->find('first', array(
			'conditions' => array(
				'Announcement.block_id' => $blockId,
				'AnnouncementDatum.language_id' => $lang,
				'AnnouncementDatum.status_id' => $this->isPublish,
			),
			'order' => 'AnnouncementDatum.id DESC'
		));
	}

/**
 * 保存する
 *
 * @param array $data postされたデータ
 * @param int $userId  User.id
 * @param int $roomId  room_id
 * @param bool $isAjax ajax判定
 * @return array
 */
	public function saveData($data, $frameId, $blockId, $dataId, $userId, $isAjax = false) {
		//例外処理をあとで追加する。
		//Modelセット
		$this->__setModel();

		//複合
		$isAjax = 1;
		$data = $this->__decodeContent($data, $isAjax);

		//status_idの取得
		$statusId = $this->__getStatusId($data);

		//本体のIDを取得する
		$announcementId = $this->__Announcement->getByBlockId($blockId);
		if(! $announcementId || $announcementId < 1) {
			//なければ作成
			$announcementId =  $this->__createAnnouncement($blockId , $userId);
		}

		//登録情報をつくる
		$insertData = array();
		$insertData[$this->name]['announcement_id'] = $announcementId;
		$insertData[$this->name]['create_user_id'] = $userId;
		$insertData[$this->name]['language_id'] = $data[$this->name]['langId'];
		$insertData[$this->name]['status_id'] = $statusId;
		$insertData[$this->name]['content'] = $data[$this->name]['content'];

		return $this->save($insertData);

	}

/**
 * Announcementのinsert処理
 *
 * @param int $blockId
 * @param int $userId
 * @return int | null
 */
	private function __createAnnouncement($blockId , $userId) {
		//announcement_blocksも作成する必要がある。
		//blockの設定テーブルも作る必要が有る。
		//現状のこれは仮実装の状態
		$d = array();
		$d['Announcement']['block_id'] = $blockId;
		$d['Announcement']['create_user_id'] = $userId;
		$rtn = $this->__Announcement->save($d);
		return  $rtn['Announcement']['id'];
	}

/**
 * Ajax通信用にエンコードされている本文をデコードする。
 *
 * @param array $data postされたデータ
 * @param bool $isAjax ajax判定
 * @return array mixed 加工されたデータ
 */
	private function __decodeContent($data, $isAjax) {
		if ($isAjax) {
			//decode
			$data[$this->name]['content'] = rawurldecode($data[$this->name]['content']);
		}
		return $data;
	}

/**
 * statusを設定する。
 *
 * @param array $data postされたデータ
 * @return array
 */
	private function __getStatusId($data) {
		$statusId = null;
		if(isset($this->type[$data[$this->name]['type']])
			&& $this->type[$data[$this->name]['type']]) {
			$statusId = intval($this->type[$data[$this->name]['type']]);
		}
		return $statusId;
	}


/**
 * model objectを格納する
 *
 * @return void
 */
	private function __setModel() {
		$this->__Block = Classregistry::init("Announcements.AnnouncementBlockBlock");
		$this->__Announcement = Classregistry::init("Announcements.Announcement");
		$this->__AnnouncementBlock = Classregistry::init("Announcements.AnnouncementBlock");
		$this->__Frame = Classregistry::init("Announcements.AnnouncementFrame");
	}

}