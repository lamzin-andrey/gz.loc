<!-- //показываем кнопку получить смc -->
<div class="form getsmsform">
	<p><?=$smsVerify->infoMessage ?></p>
	<form action="/smsverify/getsms" method="POST">
		<p class="tright">
			<input type="submit" value="Получить смс" id="getSms" name="getSms">
			<input type="hidden" name="token" value="<?=$_SESSION["utoken"] ?>"
		</p>
	</form>
</div>
