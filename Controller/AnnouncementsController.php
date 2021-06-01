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
		'Workflow.WorkflowComment',
	);

/**
 * use components
 *
 * @var array
 */
	public $components = array(
		'NetCommons.Permission' => array(
			//アクセスの権限
			'allow' => array(
				'edit' => 'content_editable',
				'delete' => 'block_editable',
			),
		)
	);

/**
 * use helpers
 *
 * @var array
 */
	public $helpers = array(
		'Workflow.Workflow',
	);

/**
 * view method
 *
 * @return void
 */
	public function view() {
		$announcement = $this->Announcement->getAnnouncement();
		if (! $announcement) {
			if (Current::permission('content_editable')) {
				$announcement = $this->Announcement->createAll();
			} else {
				return $this->setAction('emptyRender');
			}
		}
		$this->set('announcement', $announcement['Announcement']);

		//新着データを既読にする
		$this->Announcement->saveTopicUserStatus($announcement);
	}

/**
 * edit method
 *
 * @return void
 */
	public function edit() {
		//お知らせは、新規登録と編集が同じアクションであるため、block_idにあたる部分に
		//不正な文字を入力しても、無視されてしまうため、チェック処理を別途追加。
		if (empty($this->params['block_id']) &&
				!empty($this->params['pass'][0]) &&
				!is_numeric($this->params['pass'][0])) {
			return $this->throwBadRequest();
		}

		if ($this->request->is('post') || $this->request->is('put')) {
			$data = $this->data;
			$data['Announcement']['status'] = $this->Workflow->parseStatus();
			unset($data['Announcement']['id']);

			if ($this->Announcement->saveAnnouncement($data)) {
				return $this->redirect(NetCommonsUrl::backToPageUrl());
			}
			$this->NetCommons->handleValidationError($this->Announcement->validationErrors);

		} else {
			//初期データセット
			if (! $this->request->data = $this->Announcement->getAnnouncement()) {
				$this->request->data = $this->Announcement->createAll();
				$this->request->data += $this->AnnouncementSetting->createBlockSetting();
			}
			$this->request->data['Frame'] = Current::read('Frame');
		}

		$comments = $this->Announcement->getCommentsByContentKey(
			$this->request->data['Announcement']['key']
		);
		$this->set('comments', $comments);
	}

/**
 * delete
 *
 * @throws BadRequestException
 * @return void
 */
	public function delete() {
		if (! $this->request->is('delete')) {
			return $this->throwBadRequest();
		}

		$this->Announcement->deleteAnnouncement($this->data);
		$this->redirect(NetCommonsUrl::backToPageUrl());
	}

}
