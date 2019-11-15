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
	<div id="add_legend">Восстановление доступа</div>
	<hr id="add_hr"/>
		<form action="/remind" method="post" name="">
			<div class="aformwrap upformwrap" id="upform">
					<div id="uperror" class="both hide">Неверно введен код</div>
					<div class="aphone" style="margin-bottom:10px;">
						<label for="login" class="slabel">Номер телефона</label><br/>
						<label for="login"><img alt="Телефон" title="Телефон" src="/images/phone32.png" /></label> 
						<?=FV::i("login", null, 0, 'style="width:70%;"') ?>
					</div>
					<div class="left captwr tc">
						<img width="174" id="cpi" src="/images/random"><br>
						<a class="smbr" id="smbr" href="#">Кликните для обновления рисунка</a>
					</div>
					<div class="left capinputs capiwr">
						<div class="left capinputs">
							<div class="capinputs tc cpcodewr">
								<input type="text" value="" id="cp" name="cp" autocomplete="off">
							</div>
							<div class="right upformbtn">
								<?=FV::sub("sup", "Отправить"); ?>
							</div>
						</div>
						<div class="both"></div>
					</div>
				<div class="both"></div>
			</div>
			<input type="hidden" name="token" value="<?=sess('utoken') ?>" />
		</form>
		<div id="mainsfrormsuccess" style="display:block"><noindex>
			Если у вас нет доступа к email указанному при подаче объявления или регистрации, <br>
			или на него не приходят письма (в настоящее время есть проблема с отправкой писем на mail.ru) <br>
			отправьте sms на номер <script>var ss = '<?php echo ADMIN_PHONE?>'; document.write(ss);</script> (mts) в котором опишите вашу проблему. <br>
			Рассматриваются только sms отправленные с того номера, под которым вы не можете авторизоваться. <br>
			Например вы можете написать "Не могу войти", мы в ответном sms вышлем новый пароль к аккаунту. <br> <br>
			Для удаления объявления отправьте например "Удали все мои объявления" - вам придет ответное sms  <br>
			с просьбой подтвердить удаление. После подтверждения все объявления поданые из аккаунта с вашим номером телефона будут удалены.
			</noindex>
		</div>
</div> 
