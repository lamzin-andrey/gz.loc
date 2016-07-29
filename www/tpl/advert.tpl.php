<? include DR . "/tpl/usermenu.tpl.php" ?>
<ul id="strip" class="lstnone mlist hnone">
	<li>
		<img  class="ii" src="<?=$data["image"] ?>">
		<div class="shortitemtext left">
			<header><h2 class="a b"><?=$data["title"] ?></h2></header>
			<div class="text">
				<?php if ((double)$data["price"]) {?>
					<div class="vprice b"><span class="name">Цена:</span>  <?=utils_money($data["price"]) ?></div>
				<?php }?>
				<div class="name"><span class="dd">Местоположение</span> <?=$data["region_name"] . " " . $data["city_name"] ?></div>
				<div class="name"><span class="dd">Контактное лицо</span> <?=$data["name"] ?></div>
				<div class="name"><span class="dd">Тип</span> <?=$data["type"] ?></div>
				<div class="name"><span class="dd">Расстояние</span> <?=$data["distance"] ?></div>
				<div class="phone">
					Телефон: <a class="dashed gn" data-id="<?=$data["id"] ?>" href="#">
						Показать</a>
				</div>
			</div>
		</div>
		<div class="both"></div>
		<div class="avte pt10"><?=$data["addtext"] ?></div>
		<div class="b please hide">
			<div class="please_in">
				<img src="/images/l-w.gif" width="16" class="ldr">
				<span >Пожалуйста, скажите, что вы звоните по объявлению на сайте GAZel.Me</span>
				<img src="/images/blank.png" class="result hide"/>
				<div class="b10">
					<div>
						<span >Нашли перевозчика? Расскажите о нем и о нас своим друзьям!</span>
					</div>
					<div>&nbsp;</div>
					<div class="slogan socbut">
						<div class="left">
							<script type="text/javascript" src="http://vk.com/js/api/share.js?93" charset="windows-1251"></script>
							<script type="text/javascript"><!--
							document.write(VK.Share.button(false,{type: "round", text: "Поделиться"}));
							--></script>
						</div>
						<div class="left">
							<a href="https://plus.google.com/share?url=<?='http://gazel.me' . $_SERVER['REQUEST_URI']?>" target="_blank"><b id="bl">G</b><b id="r">o</b><b id="ye">o</b><b id="bl">g</b><b id="gr">l</b><b id="r">e+</b></a>
						</div>
						<div class="left">
							<a id="fbook" target="_blank" href="http://www.facebook.com/share.php?u=<?='http://gazel.me' . $_SERVER['REQUEST_URI']?>"><b id="bgf">F</b>acebook</a>
						</div>
						<div class="left">
							<div class="ya-share2" data-services="odnoklassniki,moimir,twitter" data-size="s"></div>
						</div>
						
						<div class="both"></div>
					</div>
					
				</div>
				
			</div>
		</div>
	</li>	
</ul>
<?php 
/*$a = explode("?", $_SERVER["REQUEST_URI"]);
$tail = @$a[1] ? '?' . $a[1] : '';*/
$s = '';
global $baseUrl;
$s = "$baseUrl";
if ($baseUrl == '') {
	$s = '/';
}
if (@$_GET["page"]) {
	$s .= "?page=". @$_GET["page"] ;
}
?>
<a href="<?=$s ?>" id="moreitems" class="hidelink">	
	<div class="button back2list" >
		<img src="/images/lw.gif"class="plm hide"/>
		<span style="vertical-align:top; display:block-inline">Назад</span>
	</div>
</a>
