<? include DR . "/tpl/usermenu.tpl.php" ?>
<?php if (@$_SESSION["ok_msg"] && @$_GET["status"] === '0') {
?><div id="mainsfrormsuccess" class="vis"><?=@$_SESSION["ok_msg"] ?></div><?php
	unset( $_SESSION["ok_msg"] );
} ?>
<?php if (@$_SESSION["ok_msg"] && @$_GET["status"] > 0) {
?><div id="mainsfrormerror" class="vis"><?=@$_SESSION["ok_msg"] ?></div><?php
	unset( $_SESSION["ok_msg"] );
} ?>
<? FV::$obj = $rform ?>
<div id="mainsfrormadd" class="bgwhite">
	<div id="add_legend">Отписаться от рассылки</div>
	<hr id="add_hr"/>
		<form action="/unsubscribe" method="post" name="">
			<div class="aformwrap upformwrap" id="upform">
					<div id="uperror" class="both hide">Неверно введен код</div>
					<div class="aphone" style="margin-bottom:10px;">
						<label for="email" class="slabel">Email</label><br/>
						<?=FV::i("email", null, 0, 'style="width:96%;"') ?>
					</div>
					<div class="right capinputs capiwr">
						<div class="right capinputs">
							<div class="right upformbtn">
								<?=FV::sub('sup', 'Отправить'); ?>
							</div>
						</div>
						<div class="both"></div>
					</div>
				<div class="both"></div>
			</div>
			<input type="hidden" name="token" value="<?=sess('utoken') ?>" />
		</form>
</div> 
