<!-- Modal -->
<div class="modal fade" id="block-setting-<?php echo intval($frameId); ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div style="width: 90%;" class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h3 class="modal-title" id="myModalLabel"><?php echo __('お知らせ機能');?>  <?php echo __("ブロック設定"); ?></h3>
			</div>
			<div class="modal-body">
				<!-- Nav tabs -->
				<ul class="nav nav-tabs" role="tablist">
					<li class="active">
						<a href="#announcements-block-setting-parts-<?php echo intval($frameId); ?>" role="tab" data-toggle="tab">権限管理</a></li>
					<li><a href="#announcements-block-setting-update-<?php echo intval($frameId); ?>" role="tab" data-toggle="tab">更新通知</a></li>
					<li><a href="#announcements-block-setting-request-<?php echo intval($frameId); ?>" role="tab" data-toggle="tab">申請通知</a></li>
				</ul>

				<!-- Tab panes -->
				<div class="tab-content">
					<div class="tab-pane active container" id="announcements-block-setting-parts-<?php echo intval($frameId); ?>">
							<h3>公開権限管理</h3>
						<p class="container">
						<?php
							foreach($partList as $key=>$item){
								if ($item['roomParts']['can_publish_content'] == 1) {
									echo '<span class="glyphicon glyphicon-ok"></span>';
								} elseif ($item['roomParts']['can_publish_content'] == 0) {
									echo '<span class="glyphicon glyphicon-remove"></span>';
								}
								elseif ($item['roomParts']['can_publish_content'] == 2) {
									?><input type="checkbox"><?php
								}
								echo h($item['languagesParts']['name']) . "<br>";
							}
						?></p>
						<h4>編集権限管理</h4>
						<p class="container">
						<?php
						foreach($partList as $key=>$item){
							if ($item['roomParts']['can_edit_content'] == 1) {
								echo '<span class="glyphicon glyphicon-ok"></span>';
							} elseif ($item['roomParts']['can_edit_content'] == 0) {
								echo '<span class="glyphicon glyphicon-remove"></span>';
							}
							elseif ($item['roomParts']['can_edit_content'] == 2) {
								?><input type="checkbox"><?php
							}
							echo h($item['languagesParts']['name']) . "<br>";
						}
						?></p>
						<p class="text-center">
							<button type="button" class="btn btn-default" data-dismiss="modal">キャンセル</button>
							<button type="button" class="btn btn-primary"><span>更新する</span></button>
						</p>
					</div>

					<div class="tab-pane container" id="announcements-block-setting-update-<?php echo intval($frameId); ?>">
						<h3>更新通知</h3>
						<form>
						<h4>送信設定</h4>
							<input type="radio" name="send" value="1" checked> 送信する
							<input type="radio" name="send" value="0"> 送信しない
						<h4>送信先設定</h4>
							<?php
							foreach($partList as $key=>$item){
								?><input type="checkbox"> <?php
								echo h($item['languagesParts']['name']) . "<br>";
							}
							?>

						<h4>メール文書設定</h4>
							<p>
								タイトル :
								<input type="text" class="form-control">
							</p>
							<p>
								本文 :
								<textarea class="form-control" rows="5"></textarea>
							</p>
						</form>



						<p class="text-center">
							<button type="button" class="btn btn-default" data-dismiss="modal">キャンセル</button>
							<button type="button" class="btn btn-primary"><span>更新する</span></button>
						</p>
					</div>

					<div class="tab-pane container" id="announcements-block-setting-request-<?php echo intval($frameId); ?>">
						<h3>申請通知</h3>

						<form>
							<h4>送信設定</h4>
							<input type="radio" name="send" value="1" checked> 送信する
							<input type="radio" name="send" value="0"> 送信しない
							<h4>送信先設定</h4>
							<?php
							foreach($partList as $key=>$item){
								?><input type="checkbox"> <?php
								echo h($item['languagesParts']['name']) . "<br>";
							}
							?>
							<input type="checkbox"> 申請者

							<h4>メール文書設定</h4>
							<p>
								タイトル :
								<input type="text" class="form-control">
							</p>
							<p>
								本文 :
								<textarea class="form-control" rows="5"></textarea>
							</p>
						</form>




						<p class="text-center">
							<button type="button" class="btn btn-default" data-dismiss="modal">キャンセル</button>
							<button type="button" class="btn btn-primary"><span>更新する</span></button>
						</p>
					</div>


				</div>


			</div>
		</div>
	</div>
</div>
