<?php if (isset($upform->payProxyEnabled) && $upform->payProxyEnabled): ?>
<div class="aformwrap upformwrap inrelative payformwr">
	<div id="hPaymethodGr" class="hide">
		<p class="b please tj payformmsg">Оплатить <span id="nSum">0</span> рублей. Выберите способ оплаты. </p>
		<div>
			<img src="/images/p/y.png" class="pblabel">
			<input type="button" class="payvariant" id="yad" value="Яндекс Деньги">
		</div>
		<div>	
			<img src="/images/p/c.png" class="pblabel">
			<input type="button" class="payvariant" id="card" value="Банковская карта">
		</div>
		<div>
			<img src="/images/p/m.png" class="pblabel">
			<input type="button" class="payvariant" id="mob" value="Со счёта мобильного">
		</div>
	</div>
	<?php /** идентификаторы крайне важны, сумма */?>
	<div id="hPaysumGr">
		<p class="b please tj payformmsg">Время бесплатных поднятий объявлений на Gazel.Me закончилось. <br>Вы можете оплатить поднятия.</p>
		<div>
			<img src="/images/p/m.png" class="pblabel">
			<input type="button" class="paysum" id="s60" value="Поднять 1 раз - 60 Р">
		</div>
		<div>	
			<img src="/images/p/m.png" class="pblabel">
			<input type="button" class="paysum" id="s200" value="Поднять 5 раз - 200 Р">
		</div>
		<div>
			<img src="/images/p/m.png" class="pblabel">
			<input type="button" class="paysum" id="s700" value="Поднять 31 раз - 700 Р">
		</div>
	</div>
	
	<form method="POST" action="https://money.yandex.ru/quickpay/confirm.xml" id="yaform" class="hide">
		<input type="hidden" name="receiver" id="rec" value="<?php echo YAM ?>">
		<input type="hidden" name="formcomment" id="comment" value="Оплата возможности {n} поднятий объявления на сайте gazel.me">
		<input type="hidden" name="label" id="label" value="<?=sess('phone') . '|' . date('Y-m-dH:i:s') ?>">
		<input type="hidden" name="quickpay-form" value="shop">
		<input type="hidden" name="targets" id="transactionId" value="0">
		<input type="number" id="sum" name="sum" value="0" data-type="number">
		<input type="hidden" name="comment" id="comment2" value="Оплата возможности {n} поднятий объявления  на сайте gazel.me">
		<label><input type="radio" name="paymentType" id="ps" value="PC">Яндекс.Деньгами</label>
		<label><input type="radio" name="paymentType" id="bs" value="AC">Банковской картой</label>
		<label><input type="radio" name="paymentType" id="ms" value="MC">Mobile</label>
		<input type="submit" value="Перевести">
	</form>
	
</div>
<?php else:?>
<div class="aformwrap upformwrap inrelative payformwr">
	<div id="hPaysumGr">
		<p class="b please tj payformmsg">Извините, оплата поднятий временно недоступна.</p>
	</div>
</div>
<?php endif?>
