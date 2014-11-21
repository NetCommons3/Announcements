<?php
/**
 * Announcements Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AnnouncementsAppController', 'Announcements.Controller');

/**
 * Announcements Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Announcements\Controller
 */
class AnnouncementsController extends AnnouncementsAppController {

/**
 * use models
 *
 * @var array
 */
	public $uses = array(
		'Announcements.Announcement',
	);

/**
 * use components
 *
 * @var array
 */
	public $components = array(
		'NetCommons.NetCommonsBlock', //Use Announcement model
		'NetCommons.NetCommonsFrame',
		'NetCommons.NetCommonsRoomRole',
	);

/**
 * use helpers
 *
 * @var array
 */
	public $helpers = array(
		'NetCommons.NetCommonsForm'
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

		$frameId = (isset($this->params['pass'][0]) ? (int)$this->params['pass'][0] : 0);
		//Frameのデータをviewにセット
		if (! $this->NetCommonsFrame->setView($this, $frameId)) {
			throw new ForbiddenException(__d('net_commons', 'Security Error! Unauthorized input.'));
		}
		//Roleのデータをviewにセット
		if (! $this->NetCommonsRoomRole->setView($this)) {
			throw new ForbiddenException(__d('net_commons', 'Security Error! Unauthorized input.'));
		}
	}

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->view();
		if ($this->viewVars['announcement']) {
			$this->render('Announcements/view');
		}
	}

/**
 * view method
 *
 * @return void
 */
	public function view() {
		//Announcementデータを取得
		$announcement = $this->Announcement->getAnnouncement(
				$this->viewVars['blockId'],
				$this->viewVars['contentEditable']
			);

		//Announcementデータをviewにセット
		$this->set('announcement', $announcement);
		if (! $announcement) {
			$this->render(false);
		}
	}

/**
 * setting method
 *
 * @return void
 */
	public function setting() {
		//編集権限チェック
		if (! $this->viewVars['contentEditable']) {
			throw new ForbiddenException(__d('net_commons', 'Security Error! Unauthorized input.'));
		}

		$this->layout = 'NetCommons.modal';
		$this->view();
		$this->set('title_for_layout', __d('announcements', 'plugin_name'));
	}

/**
 * edit method
 *
 * @return void
 */
	public function edit() {
		//編集権限チェック
		if (! $this->viewVars['contentEditable']) {
			throw new ForbiddenException(__d('net_commons', 'Security Error! Unauthorized input.'));
		}

		//POSTチェック
		if ($this->request->isPost()) {
			//公開権限チェック
			if (! isset($this->data['Announcement']['status'])) {
				throw new ForbiddenException(__d('net_commons', 'Security Error! Unauthorized input.'));
			}
			if (! $this->viewVars['contentPublishable'] && (
					$this->data['Announcement']['status'] === NetCommonsBlockComponent::STATUS_PUBLISHED ||
					$this->data['Announcement']['status'] === NetCommonsBlockComponent::STATUS_DISAPPROVED
				)) {
				throw new ForbiddenException(__d('net_commons', 'Security Error! Unauthorized input.'));
			}
			//登録
			$result = $this->Announcement->saveAnnouncement($this->data);
			if (! $result) {
				throw new ForbiddenException(__d('net_commons', 'Security Error! Unauthorized input.'));
			}
		}

		//最新データ取得
		$this->view();

		//コメントデータ取得
		if ($this->request->isPost()) {
			$results = array('announcement' => $this->viewVars['announcement']);
			$this->renderJson($results, __d('net_commons', 'Successfully finished.'));
		} else {
			$content_key = $this->viewVars['announcement']['Announcement']['key'];
			$view = $this->requestAction(
					'/comments/comments/index/announcements/' . $content_key . '.json', array('return'));
			$comments = json_decode($view, true);
			//JSON形式で戻す
			$results = Hash::merge($comments['results'], array('announcement' => $this->viewVars['announcement']));

			$this->renderJson($results);
		}
	}

/**
 * token method
 *
 * @return void
 */
	public function token() {
		$this->view();
		$this->render('Announcements/token', false);
	}

}
