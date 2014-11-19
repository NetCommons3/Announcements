<?php
/**
 * announcement edit view template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

$formName = 'AnnouncementForm' . (int)$frameId;

?>

<div id="nc-top"></div>

<?php echo $this->element('AnnouncementEdit/tab_header'); ?>

<div class="modal-body">
	<div class="tab-content">
		<div id="nc-announcements-edit-<?php echo $frameId; ?>" class="tab-pane active">

			<?php echo $this->Form->create('Announcement' . (int)$frameId, array(
					'type' => 'get',
					'ng-init' => 'initialize()',
					'name' => $formName,
					'novalidate' => true
				)); ?>

				<div class="panel panel-default">
					<div class="panel-body has-feedback">
						<?php echo $this->element('AnnouncementEdit/edit_form', array('formName' => $formName)); ?>

						<hr />

						<?php echo $this->element('AnnouncementEdit/comment_form', array('formName' => $formName)); ?>
					</div>

					<?php echo $this->element('AnnouncementEdit/button', array('formName' => $formName)); ?>
				</div>

				<div class="panel panel-default" ng-show="comments.visibility">
					<?php echo $this->element('AnnouncementEdit/comment_list'); ?>
				</div>

				<?php echo $this->element('AnnouncementEdit/common_form'); ?>

			<?php echo $this->Form->end(); ?>
		</div>
	</div>
</div>
