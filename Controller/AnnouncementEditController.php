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
App::uses('Comment', 'Blocks.Model'); //当定義がないと、エラーになる
//App::uses('CommentsController', 'Comments.Controller');

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
		'Blocks.Comment',
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

		//Frameのデータをviewにセット
		$frameId = (int)$this->params['pass'][0];
		//$frameId = 0;
		if (! $this->NetCommonsFrame->setView($this, $frameId)) {
			throw new ForbiddenException(__d('net_commons', 'Security Error! Unauthorized input.'));
		}

		//Roleのデータをviewにセット
		if (! $this->NetCommonsRoomRole->setView($this)) {
			throw new ForbiddenException(__d('net_commons', 'Security Error! Unauthorized input.'));
		}

		//編集権限チェック
		if (! $this->viewVars['contentEditable']) {
			throw new ForbiddenException(__d('net_commons', 'Security Error! Unauthorized input.'));
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
			//HTMLで出力
			$this->viewClass = 'View';
			$this->response->type('html');
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
		$this->comments($frameId, Comment::STARTLIMIT);

		$content_key = $this->viewVars['announcement']['Announcement']['key'];
		$view = $this->requestAction(
				'/comments/comments/index/announcements/' . $content_key . '.json', array('return'));

//		$commentsController = new CommentsController;
//		$commentsController->constructClasses();
//		$view = $commentsController->index('announcements', $this->viewVars['announcement']['Announcement']['key']);

		CakeLog::debug($view);
		CakeLog::debug(gettype($view));
//		CakeLog::debug(print_r($view, true));
//		CakeLog::debug((is_string($view) ? 'true' : 'false'));

		$aaa = json_decode($view, true);
//		var_dump($aaa);

		CakeLog::debug(print_r($aaa, true));

		return $this->render('AnnouncementEdit/view_latest', false);
	}

/**
 * comments method
 *
 * @param int $frameId frames.id
 * @param int $limit limit
 * @return CakeResponse A response object containing the rendered view.
 * @throws ForbiddenException
 */
	public function comments($frameId = 0, $limit = 0) {

		CakeLog::debug(print_r($this->params, true));

		if (! isset($this->viewVars['announcement'])) {
			$this->view($frameId);
		}
		if ($limit === 0) {
			$limit = Comment::MAXLIMIT;
		}

		//コメントデータを取得
		$this->Paginator->settings = array(
			'Comment' => array(
				'fields' => array(
					'Comment.id',
					'Comment.comment',
					'Comment.created_user',
					'Comment.created',
					'CreatedUser.key',
					'CreatedUser.value',
				),
				'conditions' => array(
					'Comment.content_key' => $this->viewVars['announcement']['Announcement']['key'],
				),
				'limit' => $limit,
				'order' => 'Comment.id DESC',
			),
			'CreatedUser' => array(
				'conditions' => array(
					'Comment.created_user = CreatedUser.user_id',
					'CreatedUser.language_id' => $this->viewVars['languageId'],
					'CreatedUser.key' => 'nickname'
				)
			)
		);
		$comments = $this->Paginator->paginate('Comment');
		$this->set('comments', $comments);
		$this->set('limit', $limit);

		if ($this->params['action'] === 'comments') {
			return $this->render('AnnouncementEdit/comments', false);
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

		//HTMLで出力
		$this->viewClass = 'View';
		$this->response->type('html');
		return $this->render('AnnouncementEdit/form', false);
	}

/**
 * post method
 *
 * @param int $frameId frames.id
 * @return string JSON that indicates success
 * @throws ForbiddenException
 */
	public function edit($frameId = 0) {
		//POSTチェック
		if (! $this->request->isPost()) {
			throw new ForbiddenException(__d('net_commons', 'Security Error! Unauthorized input.'));
		}

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
