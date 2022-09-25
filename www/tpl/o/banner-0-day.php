<?php if ( strpos($_SERVER['HTTP_USER_AGENT'], 'yandex.com') === false ): ?>
<noindex>
<div class="osagobanner_sber s">
	<a href="/osago"><section>
		<?php
			$x = 13 - intval(date('d'));
		?>
		<img src="/images/o/f.png"><b><?=pluralize($x, '', 'ОСТАЛСЯ', 'ОСТАЛОСЬ', 'ОСТАЛОСЬ')?> <?=$x?>  <?=pluralize($x, '', 'день', 'дня', 'дней')?> до подорожания ОСАГО! Успей оформить!</b>
	</section></a>
</div>
</noindex>
<?php endif ?>
