<? include DR . "/tpl/usermenu.tpl.php" ?>
<div id="mainsfrormadd" class="bgwhite">
	<div id="add_legend">Поднять объявление</div>
	
	<?php if (sess('successKey') == 'fail'): ?>
	<div id="mainsfrormerror" style="display:block"><p>Не удалось произвести оплату. Если с вашего счета списались деньги, свяжитесь с нами через <a href="/fb">форму обратной связи</a></p></div>
	<?php sess('successKey', 'unset'); ?>
	<?php endif ?>
	
	<?php if (sess('successKey') == 'success'): ?>
	<div id="mainsfrormsuccess" style="display:block"><p>Оплата прошла успешно. В течении нескольких минут вам станут доступны поднятия объявлений.</p>
	<script>
		setTimeout(function(){window.location.href = window.location.href;}, 30*1000)
	</script>
	</div>
	<?php sess('successKey', 'unset'); ?>
	<?php endif ?>
	
	<hr id="add_hr"/>
		<?php if ($upform->upCount > 0): ?>
			<?php if (!defined('PAY_ENABLED')):?>
			<p class="b please tc">В <?=$upform->emonth()?> вы можете поднять ваши объявления ещё <?=$upform->upCount?> <?php echo pluralize($upform->upCount, '', 'раз', 'раза', 'раз') ?></p>
			<?php else: ?>
			<p class="b please tc">Вы можете поднять ваше объявление <?=$upform->upCount?> <?php echo pluralize($upform->upCount, '', 'раз', 'раза', 'раз') ?></p>
			<?php endif ?>
		<?php else : ?>
			<?php include $upform->unavialableTpl ; ?>
		<?php endif?>
		<form action="/cabinet/up/<?=$upform->id ?>" method="post" name="">
			<div class="aformwrap upformwrap" id="upform">
					<div id="uperror" class="both hide">Неверно введен код</div>
					<div class="f10">Для того, чтобы поднять в результатах поиска объявление "<?=$upform->title ?>" 
					введите текст с изображения ниже и нажмите кнопку "Поднять". 
					</div>
					<div>
						<div class="left captwr tc">
							<img width="174" id="cpi" src="/images/random"><br><a class="smbr" id="smbr" href="#">Кликните для обновления рисунка</a>
						</div>
						<div class="left capinputs capiwr">
							<div class="left capinputs">
								<div class="capinputs tc cpcodewr">
									<input type="text" value="" id="cp" name="cp">
								</div>
								<div class="right upformbtn">
									<?=FV::sub("sup", "Поднять"); ?>
								</div>
							</div>
							<div class="both"></div>
						</div>
						<div class="both"></div>
					</div>
			</div>
			<input type="hidden" name="token" value="<?=@$_SESSION["utoken"] ?>" />
		</form>
		
		<?php /*form method="POST" action="https://money.yandex.ru/quickpay/confirm.xml">
			<input type="hidden" name="receiver" value="410011041419724">
			<input type="hidden" name="formcomment" value="Проект «Железный человек»: реактор холодного ядерного синтеза">
			<input type="hidden" name="short-dest" value="Проект «Железный человек»: реактор холодного ядерного синтеза">
			<input type="hidden" name="label" value="$order_id">
			<input type="hidden" name="quickpay-form" value="donate">
			<input type="hidden" name="targets" value="транзакция {order_id}">
			<input type="number" name="sum" value="100" data-type="number">
			<input type="hidden" name="comment" value="Хотелось бы получить дистанционное управление.">
			<input type="hidden" name="need-fio" value="true">
			<input type="hidden" name="need-email" value="true">
			<input type="hidden" name="need-phone" value="false">
			<input type="hidden" name="need-address" value="false">
			<label><input type="radio" name="paymentType" value="PC">Яндекс.Деньгами</label>
			<label><input type="radio" name="paymentType" value="AC">Банковской картой</label>
			<label><input type="radio" name="paymentType" value="MC">Mobile</label>
			<input type="submit" value="Перевести">
		</form*/ ?>
</div> 



