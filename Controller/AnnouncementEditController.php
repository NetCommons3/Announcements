<?php
/**
 * Announcement edit Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AnnouncementsAppController', 'Announcements.Controller');

/**
 * Announcement edit Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Announcements\Controller
 */
class AnnouncementEditController extends AnnouncementsAppController {

/**
 * use model
 *
 * @var array
 */
	public $uses = array(
		'Announcements.Announcement',
	);

/**
 * use component
 *
 * @var array
 */
	public $components = array(
		'NetCommons.NetCommonsBlock', //use Announcement model or view
		'NetCommons.NetCommonsFrame',
		'NetCommons.NetCommonsRoomRole',
		'Paginator'
	);

/**
 * beforeFilter
 *
 * @return void
 * @throws ForbiddenException
 */
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow();

		if (isset($this->data['Frame']['id'])) {
			$frameId = (int)$this->data['Frame']['id'];
		} else if (isset($this->params['pass'][0])) {
			$frameId = (int)$this->params['pass'][0];
		} else {
			$frameId = 0;
		}

		//Frameのデータをviewにセット
		if (! $this->NetCommonsFrame->setView($this, $frameId)) {
			throw new ForbiddenException();
		}

		//Roleのデータをviewにセット
		if (! $this->NetCommonsRoomRole->setView($this)) {
			throw new ForbiddenException();
		}

		//編集権限チェック
		if (! $this->viewVars['contentEditable']) {
			throw new ForbiddenException();
		}
	}

/**
 * index method
 *
 * @param int $frameId frames.id
 * @return CakeResponse A response object containing the rendered view.
 */
	public function index($frameId = 0) {
		return $this->view($frameId);
	}

/**
 * view method
 *
 * @param int $frameId frames.id
 * @return CakeResponse A response object containing the rendered view.
 * @throws ForbiddenException
 */
	public function view($frameId = 0) {
		//Announcementデータを取得
		$announcement = $this->Announcement->getAnnouncement(
				$this->viewVars['blockId'],
				$this->viewVars['contentEditable']
			);

		$this->set('announcement', $announcement);

		if ($this->params['action'] === 'view' || $this->params['action'] === 'index') {
			return $this->render('AnnouncementEdit/view', false);
		}
	}

/**
 * view latest
 *
 * @param int $frameId frames.id
 * @return CakeResponse A response object containing the rendered view.
 * @throws ForbiddenException
 */
	public function view_latest($frameId = 0) {
		//最新データ取得
		$this->view($frameId);
		//$this->comment($frameId);

		return $this->render('AnnouncementEdit/view_latest', false);
	}

/**
 * view method
 *
 * @param int $frameId frames.id
 * @return CakeResponse A response object containing the rendered view.
 * @throws ForbiddenException
 */
	public function comment($frameId = 0) {
		//コメントデータを取得
		$this->Announcement->unbindModel(array('belongsTo' => array('Block')), false);
		$this->Paginator->settings = array(
			'Announcement' => array(
				'conditions' => array(
					'Announcement.block_id' => $this->viewVars['blockId'],
					'Announcement.comment !=' => '',
				),
				'limit' => 5,
				'order' => 'Announcement.id DESC',
			)
		);
		$comments = $this->Paginator->paginate('Announcement');
		$this->Announcement->bindModel(array('belongsTo' => array('Block')), false);
		$this->set('comments', $comments);

		if ($this->params['action'] === 'comment') {
			return $this->render('AnnouncementEdit/comment', false);
		}
	}

/**
 * form method
 *
 * @param int $frameId frames.id
 * @return CakeResponse A response object containing the rendered view.
 */
	public function form($frameId = 0) {
		$this->view($frameId);
		return $this->render('AnnouncementEdit/form', false);
	}

/**
 * post method
 *
 * @return string JSON that indicates success
 * @throws MethodNotAllowedException
 * @throws ForbiddenException
 */
	public function edit() {
		if (! $this->request->isPost()) {
			throw new MethodNotAllowedException();
		}

		$postData = $this->data;
		unset($postData['Announcement']['id']);

		//登録
		$result = $this->Announcement->saveAnnouncement($postData);
		if (! $result) {
			throw new ForbiddenException(__d('net_commons', 'Failed to register data.'));
		}

		//最新データ取得
		$announcement = $this->Announcement->getAnnouncement(
				$result['Announcement']['block_id'],
				$this->viewVars['contentEditable']
			);

		$result = array(
			'name' => __d('net_commons', 'Successfully finished.'),
			'announcement' => $announcement,
		);

		$this->set(compact('result'));
		$this->set('_serialize', 'result');
		return $this->render(false);
	}
}
