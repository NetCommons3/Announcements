<div class="hidden">
	<?php

	echo $this->Form->Create(null);

	echo $this->Form->input('part_id' , array(
			'type' => 'text',
			'name' => 'data[part_id]',
			'value' => '',)
	);

	echo $this->Form->input('is_send' , array(
			'type' => 'text',
			'name' => 'data[is_send]',
			'value' => '',)
	);

	echo $this->Form->input('frame_id' , array(
			'type' => 'text',
			'name' => 'data[frame_id]',
			'value' => '',)
	);

	echo $this->Form->input('block_id' , array(
		'type' => 'text',
		'name' => 'data[block_id]',
		'value' => '',
		//'id' => 'announcements_block_setting_blockid_parts_frame_'.$flameId."_parts_".$item['AnnouncementRoomPart']['part_id']
	));

	echo $this->Form->input('language_id' , array(
		'type' => 'text',
		'name' => 'data[language_id]',
		'value' => ''));

	echo $this->Form->input('subject' , array(
		'type' => 'text',
		'name' => 'data[subject]',
		'value' => ''));

	echo $this->Form->input('body' , array(
			'type' => 'text',
			'name' => 'data[body]',
			'value' => '')
	);


	echo $this->Form->end();
	?>
</div>