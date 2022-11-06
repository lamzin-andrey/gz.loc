<!DOCTYPE html>
<html manifest="/gazel.manifest">
	<head>
		<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title><?=$GLOBALS["title"]?></title>
		<?php $assetsVersion = ASSETS_VERSION; ?>
		<link href="/styles/main.min.css?<?=$assetsVersion?>" media="all" rel="stylesheet" type="text/css" >
		<?php /*link href="/styles/main.css?<=$assetsVersion>" media="all" rel="stylesheet" type="text/css" */?>
		<?=(isset($css) ? $css : '') ?>
		<script type="text/javascript" src="/js/mootools1.4.5.js"></script>
		<?=(isset($javascript) ? $javascript : '') ?>
		<script type="text/javascript" src="/js/lib.js?<?=$assetsVersion?>"></script>
		<script type="text/javascript" src="/js/app.js?<?=$assetsVersion?>"></script>
		<script type="text/javascript">
			var token = '<?=@$_SESSION['utoken']; ?>';
			var uid   = '<?=@$_SESSION['uid']?>';
		</script>
		<?php /*script type="text/javascript" src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js" charset="utf-8"></script>
		<script type="text/javascript" src="//yastatic.net/share2/share.js" charset="utf-8"></script */?>
							
		<? if ($_SERVER['HTTP_HOST'] == 'gz.loc'):?>
			<script type="text/javascript" src="/js/test.js?a=0"></script>
		<? endif?>
		
		<? if (strpos($_SERVER['REQUEST_URI'], '/osago') !== false /*|| $_SERVER['REQUEST_URI'] == '/'*/): ?>
		<!-- Yandex.Metrika counter -->
<script type="text/javascript" >
   (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
   var z = null;m[i].l=1*new Date();
   for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}
   k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
   (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

   ym(90206633, "init", {
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true
   });
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/90206633" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
		<? endif ?>
	</head>
	<body>
		<img src="/images/gazel.jpg" class="hide"/><img src="/images/gpasy.jpeg" class="hide"/><img src="/images/term.jpg" class="hide"/><img src="/images/up.png" class="upb hide" id="uppb" /><img src="/images/l-w.gif" class="hide" /><img src="/images/lw.gif" class="hide" />
	<? if ( isset($regId) ) {?>
	<input type="hidden" id="selectedregionid" value="<?=@$regId ?>" />
	<?}?>
	<? if ( isset($cityId) ) {?>
	<input type="hidden" id="selectedcityid" value="<?=@$cityId ?>" />
	<?} ?>
		<header class="mainhead">
			<div id="logoplace">
				<div id="logo-out">
					<div id="logo-in">
						<a href="/" erid="<?=ERID_MAIN_INNER?>" data-erid="<?=ERID_MAIN_INNER?>" class="dashed novisible-dashed" data-id="<?=ERID_MAIN_INNER_ADV_ID?>">
							<img src="/images/gazeli.png"/>
						</a>
					</div>				
				</div>
				<div class="slogan">
				</div>
			</div>
			<div id="banner-out">
				<h1 id="banner-in">
					<?=$GLOBALS["h1"]?>
				</h1>
			</div>
		</header>
		
		<?php if (!isset($showOsagoAdvert)) { ?>
			<?php include TPLS . '/o/banner.php'; ?>
			<?php include TPLS . '/p100banner.php'; ?>
			
		<?php } ?>
		
		<div id="content">
			<?php 
				if ($_SERVER['REQUEST_URI'] != '/agreement'):
			?>
			<div class="seo" style="margin:10px 10px">
    			<a href="/agreement" ><span class="red">Важно!</span> Пользовательское соглашение.</a>
			</div>
			<?php endif ?>
			<div class="maincontent">
				<? include $GLOBALS['inner'] ?>
			</div>
			<div style="clear:both"> </div>
		</div>
		<div id="footer">
				<div id="counter-out">
					<div id="counter-in">
						<!--LiveInternet counter--><script type="text/javascript"><!--
document.write("<a href='http://www.liveinternet.ru/click' erid=\"<?=ERID_LIVE_INTERNET?>\" data-erid=\"<?=ERID_LIVE_INTERNET?>\" class=\"dashed novisible-dashed\" data-id=\"<?=ERID_LIVE_INTERNET_ADV_ID?>\""+
"target=_blank><img src='//counter.yadro.ru/hit?t44.10;r"+
escape(document.referrer)+((typeof(screen)=="undefined")?"":
";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
";"+Math.random()+
"' alt='' title='LiveInternet' "+
"border='0' width='31' height='31'><\/a>")
//--></script><!--/LiveInternet-->
					</div>
				</div>
				
				<div style="color: #b8b8b8;font-size: 10px;position: relative;">
					<div style="position: absolute;bottom: -22px;right: 115px;" id="hRand">45 16</div>
					<script>
						function rand(min, max) {
							var n = 0, k;
							while (n == 0) n = Math.round(Math.random()*(max-min))+min;
							k = Math.random();
							if (k > 0.5) {
								if (k > 0.75 && n == max - 1) {
									n++;
								} else if( n == min + 1){
									n--;
								}
							}
							return n;
						}
						$('hRand').innerHTML = rand(10, 99) + ' ' + rand(10, 99);
						$('hRand').onclick = function() {
							alert('Если вам 40+ перемножьте эти два числа (' + $('hRand').innerHTML +') в уме. Отличная зарядка для мозга!');
						}
					</script>
				</div>
		<div class="flink right">
			<a href="<?=POLITICS_DOC ?>">Политика конфидециальности</a>
		</div>
		<div class="clear"></div>
		</div>
	</body>
</html>
 
