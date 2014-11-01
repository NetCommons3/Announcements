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
			<form action="/announcements/announcement_edit/view/<?php echo $frameId; ?>/"
					  id="AnnouncementFormForm<?php echo $frameId; ?>">

				<div class="panel panel-default">
					<div class="panel-heading">
						内容
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
						<?php echo $this->element('AnnouncementEdit/button'); ?>
					</div>

					<div class="panel-footer">
						<?php echo __d('net_commons', 'Comment list'); ?>
					</div>

					<div class="panel-body" ng-init="comments = <?php echo h(json_encode($comments)); ?>">
						<div class="row" ng-repeat="comment in comments">
							<div class="col-sm-12" ng-hide="$first"><hr /></div>
							<div class="col-sm-4">{{comment.Announcement.created}}</div>
							<div class="col-sm-8">{{comment.Announcement.comment}}</div>
						</div>

						<hr />
						<ul class="pager" ng-init="paginator.current = <?php echo $this->Paginator->current(); ?>;
													paginator.hasPrev = <?php echo ($this->Paginator->hasPrev() ? 'true' : 'false'); ?>;
													paginator.hasNext = <?php echo ($this->Paginator->hasNext() ? 'true' : 'false'); ?>;">
							<li class="previous" ng-class="paginator.hasPrev ? '' : 'disabled'">
								<a href="#" onclick="return false;" ng-click="prevPage()">
									<?php echo __d('net_commons', 'Prev.'); ?>
								</a>
							</li>
							<li class="next" ng-class="paginator.hasNext ? '' : 'disabled'">
								<a href="#" onclick="return false;" ng-click="nextPage()">
									<?php echo __d('net_commons', 'Next'); ?>
								</a>
							</li>
						</ul>
					</div>

				</div>

				<?php echo $this->element('AnnouncementEdit/common_form'); ?>
			</form>
 <?php //foreach($comments as $v): ?>
 <?php //echo $v['Announcement']['id']; ?>
 <?php //endforeach; ?>

		</div>
	</div>
</div>
