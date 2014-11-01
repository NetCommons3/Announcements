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

<?php
	echo $this->Form->input('Announcement.comment', array(
				'label' => __d('net_commons', 'Comment'),
				'rows' => '1',
				'type' => 'textarea',
				'class' => 'form-control',
				'ng-model' => 'edit.data.Announcement.comment',
				'placeholder' => __d('net_commons', 'If it is not approved, please input.'),
				'autofocus' => 'true',
			)
		);
?>

<br />
<div class="text-center">
	<button type="button" class="btn btn-default" ng-click="cancel()" ng-disabled="sending">
		<span class="glyphicon glyphicon-remove"></span>
		<?php echo __d('net_commons', 'Cancel'); ?>
	</button>

	<?php if (isset($announcement['Announcement']) && $contentPublishable &&
				$announcement['Announcement']['status'] === NetCommonsBlockComponent::STATUS_APPROVED) : ?>
		<button type="button" class="btn btn-danger" ng-disabled="sending"
				ng-hide="announcement.Announcement.status !== '<?php echo (NetCommonsBlockComponent::STATUS_APPROVED); ?>'"
				ng-click="save('<?php echo NetCommonsBlockComponent::STATUS_DISAPPROVED ?>')">
			<?php echo __d('net_commons', 'Disapproval'); ?>
		</button>

		<button type="button" class="btn btn-default ng-hide" ng-disabled="sending"
				ng-hide="announcement.Announcement.status === '<?php echo (NetCommonsBlockComponent::STATUS_APPROVED); ?>'"
				ng-click="save('<?php echo NetCommonsBlockComponent::STATUS_DRAFTED ?>')">
			<?php echo __d('net_commons', 'Save temporally'); ?>
		</button>
	<?php else : ?>
		<button type="button" class="btn btn-default" ng-disabled="sending"
				ng-click="save('<?php echo NetCommonsBlockComponent::STATUS_DRAFTED ?>')">
			<?php echo __d('net_commons', 'Save temporally'); ?>
		</button>

	<?php endif; ?>

	<?php if ($contentPublishable) : ?>
		<button type="button" class="btn btn-primary" ng-disabled="sending"
				ng-click="save('<?php echo NetCommonsBlockComponent::STATUS_PUBLISHED ?>')">
			<?php echo __d('net_commons', 'OK'); ?>
		</button>

	<?php else : ?>
		<button type="button" class="btn btn-primary" ng-disabled="sending"
				ng-click="save('<?php echo NetCommonsBlockComponent::STATUS_APPROVED ?>')">
			<?php echo __d('net_commons', 'OK'); ?>
		</button>

	<?php endif; ?>

</div>
