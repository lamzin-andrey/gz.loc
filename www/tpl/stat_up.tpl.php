<? include DR . "/tpl/usermenu.tpl.php" ?>
<? include DR . "/tpl/adminmenu.tpl.php" ?><?php
if ($statUp->numRows) {
	?><ul class="lstnone"><?
	foreach ($statUp->rows as $r) {
		?><li><?=$r["_date"] ?>, <?=$r["_count"]?></li><?
	}
	?></ul><?
} else {
	?><div id="mainsfrormsuccess" class="vis">Об этом история умалчивает</div><?php
}?>
<div style="float:left">
		<a href="private/stat_up?page=<?=$statUp->prev?>">&lt;</a>
</div>
<div style="float:right; width:100px;">&nbsp;</div>
<div style="float:right">
		<a href="private/stat_up?page=<?=$statUp->next?>">&gt;</a>
</div>
<div style="clear:both"></div>
