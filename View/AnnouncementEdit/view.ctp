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
?>

<?php echo $this->element('AnnouncementEdit/tab_header'); ?>

<div class="modal-body">
	<div class="tab-content">
		<div id="nc-announcements-edit-<?php echo $frameId; ?>"
				class="tab-pane active">
			<?php echo $this->Form->create('Announcement' . (int)$frameId,
											array('ng-init' => 'initialize()')); ?>

				<div class="panel panel-default">
					<div class="panel-heading">
						<?php echo __d('announcements', 'Edit announcement'); ?>
					</div>

					<div class="panel-body">
						<textarea required class="form-control" rows="3"
								ui-tinymce="tinymceOptions"
								ng-model="edit.data.Announcement.content">
						</textarea>
					</div>
				</div>

				<div class="panel panel-default">
					<div class="panel-body">
						<?php
							echo $this->Form->input('Announcement.comment', array(
										'label' => __d('net_commons', 'Comment'),
										'rows' => '2',
										'type' => 'textarea',
										'class' => 'form-control',
										'ng-model' => 'edit.data.Announcement.comment',
										'placeholder' => '{{placeholders.comment}}',
										'ng-init' => "setPlaceholder('comment', '". __d('net_commons', 'If it is not approved, please input.') ."')",
										'autofocus' => 'true',
									)
								);
						?>
						<?php echo $this->element('AnnouncementEdit/button'); ?>
					</div>

					<?php echo $this->element('AnnouncementEdit/comment_list'); ?>
				</div>

				<?php echo $this->element('AnnouncementEdit/common_form'); ?>

			<?php echo $this->Form->end(); ?>
		</div>
	</div>
</div>
