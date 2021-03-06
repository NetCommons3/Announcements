<?php
/**
 * AnnouncementBlocks Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AnnouncementsAppController', 'Announcements.Controller');

/**
 * AnnouncementBlocks Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Announcements\Controller
 */
class AnnouncementBlocksController extends AnnouncementsAppController {

/**
 * layout
 *
 * @var array
 */
	public $layout = 'NetCommons.setting';

/**
 * use components
 *
 * @var array
 */
	public $components = array(
		'Workflow.Workflow',
		'NetCommons.Permission' => array(
			'allow' => array(
				'index,add,edit,delete' => 'block_editable',
			),
		),
		'Paginator',
	);

/**
 * use helpers
 *
 * @var array
 */
	public $helpers = array(
		'Blocks.BlockForm',
		'Blocks.BlockIndex',
		'Blocks.BlockTabs' => array(
			'mainTabs' => array('block_index'),
			'blockTabs' => array('block_settings', 'mail_settings', 'role_permissions'),
		),
		'Workflow.Workflow',
	);

/**
 * index
 *
 * @return void
 */
	public function index() {
		$this->Paginator->settings = array(
			'Announcement' => $this->Announcement->getBlockIndexSettings([
				'conditions' => array('Announcement.is_latest' => true)
			])
		);

		$announcements = $this->Paginator->paginate('Announcement');
		if (! $announcements) {
			$this->view = 'Blocks.Blocks/not_found';
			return;
		}
		$this->set('announcements', $announcements);

		$this->request->data['Frame'] = Current::read('Frame');
	}

/**
 * add
 *
 * @return void
 */
	public function add() {
		$this->view = 'edit';

		if ($this->request->is('post')) {
			//登録(POST)処理
			$data = $this->data;
			$data['Announcement']['status'] = $this->Workflow->parseStatus();

			if ($this->Announcement->saveAnnouncement($data)) {
				return $this->redirect(NetCommonsUrl::backToIndexUrl('default_setting_action'));
			}
			$this->NetCommons->handleValidationError($this->Announcement->validationErrors);

		} else {
			//初期データセット
			$this->request->data = $this->Announcement->createAll();
			$this->request->data += $this->AnnouncementSetting->createBlockSetting();
			$this->request->data['Frame'] = Current::read('Frame');
		}
	}

/**
 * edit
 *
 * @return void
 */
	public function edit() {
		if ($this->request->is('put')) {
			$data = $this->data;
			$data['Announcement']['status'] = $this->Workflow->parseStatus();
			unset($data['Announcement']['id']);

			if ($this->Announcement->saveAnnouncement($data)) {
				return $this->redirect(NetCommonsUrl::backToIndexUrl('default_setting_action'));
			}
			$this->NetCommons->handleValidationError($this->Announcement->validationErrors);

		} else {
			//初期データセット
			$this->request->data = $this->Announcement->getAnnouncement();
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
		$this->redirect(NetCommonsUrl::backToIndexUrl('default_setting_action'));
	}

}
