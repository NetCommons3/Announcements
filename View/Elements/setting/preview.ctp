<?php
/**
 * @codeCoverageIgnore
 */
?>
<div
	ng-init="Preview.html=''"
	ng-init="View.edit.preview=false"
	ng-show="View.edit.preview"
	ng-bind-html="Preview.html"
	class="ng-hide">
	{{Preview.html}}
</div>