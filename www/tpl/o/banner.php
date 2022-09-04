<?php if ( strpos($_SERVER['HTTP_USER_AGENT'], 'yandex.com') === false ): ?>
<noindex>
<div class="osagobanner_sber s">
	<a href="/osago"><section>
		<img src="/images/o/f.png"><b>ОСТАЛОСЬ <?=13 - intval(date('d'))?> дней до подорожания ОСАГО! Успей оформить!</b>
	</section></a>
</div>
</noindex>
<?php endif ?>
