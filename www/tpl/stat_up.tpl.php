<? include DR . "/tpl/usermenu.tpl.php" ?>
<? include DR . "/tpl/adminmenu.tpl.php" ?>

<div class="countVerify">
	Количество подтвердивших номера по смс <?=$statUp->countIsSmsVerify?>
</div>
<div class="both"></div>

<?php
if ($statUp->numRows) {
	?><ul class="lstnone"><?
	foreach ($statUp->rows as $r) {
		?><li><?=$r["_date"] ?>, <?=$r["_count"]?></li><?
	}
	?></ul><?
} else {
	?><div id="mainsfrormsuccess" class="vis" style="margin-bottom:300px;">Об этом история умалчивает</div><?php
}?>
<div style="float:left">
		<a href="/private/stat_up?page=<?=$statUp->prev?>">&lt;</a>
</div>
<div style="float:left; width:100px;">&nbsp;</div>
<div style="float:left">
		<a href="/private/stat_up?page=<?=$statUp->next?>">&gt;</a>
</div>
<div style="clear:both"></div>
