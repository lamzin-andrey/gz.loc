		<li>
			<img src="<?=$n['image'] ?>" class="ii" title="<?=$n['addtext'] ?>" />
			<div class="shortitemtext left">
				<header><a href="<?=$n["link"] ?>"  title="<?=$n['addtext'] ?>"><?=$n['title'] ?></a></header>
				<div class="text">
					<?php // erid="?=$n["ordya_erid"] ?" data-erid="?=$n["ordya_erid"] ?" ?>
					<?php if ($n['price'] > 0) {?><div class="vprice b"><span class="name">Цена:</span> <?=Shared::price($n['price']) ?></div><?} ?>
					<div class="name"><?=$n['region_name'] ?>  <?=$n['city_name'] ?></div>
					<div class="name"><?=$n['name'] ?></div>
					<div class="name"><?=$n['type'] ?></div>
					<div class="phone">
						Телефон: <a href="#" data-id="<?=$n['id'] ?>" class="dashed gn">Показать</a>
					</div>
				</div>
			</div>
			<div class="both"></div>
			<div class="b please hide">
				<div class="please_in">
					<img src="/images/l-w.gif" width="16" class="ldr">
					<span >Пожалуйста, скажите, что вы звоните по объявлению на сайте GAZel.Me</span>
					<img src="/images/blank.png" class="result hide"/>
					
					<div>
						<span >Нашли перевозчика? Расскажите о нем и о нас своим друзьям!</span>
					</div>
					<div class="slogan socbut">
							<div class="ya-share2" data-services="vkontakte,facebook,odnoklassniki,moimir,gplus,twitter,linkedin,viber,whatsapp"></div>
					</div>
					
					
				</div>
			</div>
		</li>
