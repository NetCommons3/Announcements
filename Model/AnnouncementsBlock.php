<?php
/**
 * AnnouncementsBlock Model
 *
 * @author   Takako Miyagawa <nekoget@gmail.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('AppModel', 'Model');

/**
 * Summary for Announcement Model
 */
class AnnouncementsBlock extends AppModel {

/**
 * validation
 *
 * @var array
 */
	public $validate = array(
		'block_id' => array(
			'rule' => array(
				'numeric',
				'notEmpty',
				'required'
			)
		),
		'create_user' => 'numeric',
		'modified_user' => 'numeric'
	);

/**
 * belongsTo
 *
 * @var string
 */
	public $belongsTo = array(
		'Block' => array(
			'className' => 'Block',
			'foreignKey' => 'block_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Room' => array(
			'className' => 'Room',
			'foreignKey' => 'room_id',
			'conditions' => 'Block.room_id=Room.id',
			'fields' => '',
			'order' => ''
		)
	);
}

