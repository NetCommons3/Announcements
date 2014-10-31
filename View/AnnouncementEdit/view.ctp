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
			<p>
				<form action="/announcements/announcement_edit/view/<?php echo $frameId; ?>/"
					  id="AnnouncementFormForm<?php echo $frameId; ?>">

					<textarea required class="form-control" rows="3"
							ui-tinymce="tinymceOptions"
							ng-model="edit.data.Announcement.content">
					</textarea>

					<?php echo $this->element('AnnouncementEdit/common_form'); ?>
				</form>
			</p>

			<?php echo $this->element('AnnouncementEdit/button'); ?>

			<?php
//$this->Paginator->options(array('url' => 'comment_history'));

//var_dump($this->Paginator->url());

echo $this->Paginator->prev('< 前へ', array('ng-click' => 'movePage($event)', 'onclick' => 'return false;'), null, array('class' => 'prev disabled'));
echo $this->Paginator->next('次へ >', array('ng-click' => 'movePage($event)', 'onclick' => 'return false;'), null, array('class' => 'next disabled'));
?>
 <?php //foreach($comments as $v): ?>
 <?php //echo $v['Announcement']['id']; ?>
 <?php //endforeach; ?>

		</div>
	</div>
</div>
