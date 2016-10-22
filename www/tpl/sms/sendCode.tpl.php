<?php
	if ($smsVerify->resultSuccess) {
		?><div id="mainsfrormsuccess" style="display: block;">
			<p><?=$smsVerify->successMessage?></p>
		</div>
		<?
	} else{?>
	<!-- //показываем надпись Вам отправлено смс с кодом, введите код в это поле -->
	<div class="form getsmsform">
		<form action="/smsverify/verify" method="POST">
		<span>Вам отправлено смс с кодом, введите код в это поле </span><input type="text" value="" id="smsCode" name="smsCode">
		<div class="iblock">
			<span class="red"><?=$smsVerify->invalidCodeMessage?></span>
		</div>
		<?=FV::sub('n', 'Отправить код из sms')?>
		<input type="hidden" name="token" value="<?=$_SESSION["utoken"] ?>">
		
		</form>
	</div>
	<?php include __DIR__ . '/getSmsButton.tpl.php'; ?>
	<!-- //показываем надпись Повторная отправка смс возможна через 15 минут (вычисляемое значение) -->
	<?php if ($smsVerify->timeoutMinutes > 0) :?>
	<div class="form getsmsform slogan">
		<span>Повторная отправка смс возможна через <span><?=$smsVerify->timeoutMinutes?></span></span>
	</div>
	<?php endif?>
<?php } ?>

