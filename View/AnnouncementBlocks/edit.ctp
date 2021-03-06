<?php
/**
 * Blocks edit template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

echo $this->NetCommonsHtml->script(array(
	'/announcements/js/announcements.js'
));

$announcement = NetCommonsAppController::camelizeKeyRecursive(array('announcement' => $this->data['Announcement']));
?>

<div class="block-setting-body"
	ng-controller="Announcements"
	ng-init="initialize(<?php echo h(json_encode($announcement)); ?>)">

	<?php echo $this->BlockTabs->main(BlockTabsHelper::MAIN_TAB_BLOCK_INDEX); ?>

	<div class="tab-content">
		<?php echo $this->BlockTabs->block(BlockTabsHelper::BLOCK_TAB_SETTING); ?>

		<?php echo $this->element('Announcements.AnnouncementBlocks/edit_form'); ?>

		<?php echo $this->Workflow->comments(); ?>
	</div>
</div>
