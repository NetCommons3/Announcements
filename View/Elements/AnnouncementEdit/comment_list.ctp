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

<div class="panel-footer">
	<button type="button" class="btn btn-default btn-block"
			ng-disabled="comments.disabled"
			ng-click="displayComments()">
		<?php echo __d('net_commons', 'Comment list'); ?>
	</button>
</div>

<div class="panel-body"
		ng-show="comments.visibility">
	<div class="row" ng-repeat="comment in comments.data">
		<div class="col-sm-12" ng-hide="$first"><hr /></div>
		<div class="col-sm-4">
			{{comment.Announcement.created}}
		</div>
		<div class="col-sm-8">
			<a href="#" onclick="$(this).popover('show'); return false;"
				title=""
				data-toggle="popover"
				data-trigger="focus"
				data-placement="top"
				data-content="{{comment.Announcement.comment}}">

				{{comment.Announcement.comment | limitTo:<?php echo Announcement::COMMENT_LENGTH ?>}}
			</a>
		</div>
	</div>

	<hr />
	<ul class="pager" ng-init="comments.current = <?php echo $this->Paginator->current(); ?>;
								comments.hasPrev = <?php echo ($this->Paginator->hasPrev() ? 'true' : 'false'); ?>;
								comments.hasNext = <?php echo ($this->Paginator->hasNext() ? 'true' : 'false'); ?>;">
		<li class="previous" ng-class="comments.hasPrev ? '' : 'disabled'">
			<a href="#" onclick="return false;" ng-click="prevComments()">
				<?php echo __d('net_commons', 'Prev.'); ?>
			</a>
		</li>
		<li class="next" ng-class="comments.hasNext ? '' : 'disabled'">
			<a href="#" onclick="return false;" ng-click="nextComments()">
				<?php echo __d('net_commons', 'Next'); ?>
			</a>
		</li>
	</ul>
</div>
