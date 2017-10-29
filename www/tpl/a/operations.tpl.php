<? include DR . "/tpl/adminmenu.tpl.php" ?>
<? FV::$obj = $ops ?>
<div id="mainsfrormadd" class="bgwhite">
	<div id="add_legend">Операции  пользователя</div>
	<hr id="add_hr"/>
		<form action="/private/ops">
			<div class="aformwrap upformwrap">
					<div class="aphone oplist">
						<label for="phone" class="slabel">Телефон</label><br/>
						<?=FV::i('phone', null, 0, 'class="opsphone"') ?>
					</div>
					<div>
						<?=FV::radio('3', 'otype', 'Расход', '3') ?>
						<?=FV::radio('2', 'otype', 'Пополнение', '2') ?>
						<?=FV::radio('1', 'otype', 'Подарок', '1') ?>
					</div>
					<div class="dateinputs">
						<?=FV::labinp('from', 'С') ?><br><?=FV::labinp('to', 'по') ?> 
					</div>
					<div class="right upformbtn">
						<?=FV::sub("sup", "Отправить"); ?>
					</div>
			</div>
			<input type="hidden" name="token" value="<?=sess('utoken') ?>" />
			<input type="hidden" name="action" value="gpwd" />
		</form>
</div>
<a href="/private/cq" class="tdn">
	<div class="button" id="bClearSms">Очистить очередь sms с кодами</div>
</a>

<?php if (sess('clearcodescomplete')) : ?>
	<div id="mainsfrormsuccess" style="display:block" class="clearqueuemsg">
		<p><?php echo sess('clearcodescomplete')?></p>
	</div>
<?php sess('clearcodescomplete', 'unset'); ?>
<?php endif ?>

<div class="operations">
	<div class="right">Сумма списаний и зачислений:</div>
	<div class="both"></div>
	<div class="right"><?=$ops->countedSumm ?></div>
	<div class="both"></div>
	<div class="right">Баланс: <?=$ops->balance ?></div>
	<div class="both"></div>
</div>
<?php if (is_array($ops->rows)): ?>
<div class="operations">
<div class="operation_heading">
<div class="left created">Дата:</div>
<div class="left phone">Телефон:</div>
<div class="left operation_head">Операция:</div>
<div class="left advlink">Объявление:</div>
<div class="left upcount">Поднятия:</div>
<div class="left sum">Сумма, потраченная пользователем:</div>
<div class="left approved">Идентификатор подтвержденной записи:</div>
<div class="both"></div>
</div>
<?php foreach ($ops->rows as $row): ?>
<div class="operation">
<div class="left created"><strong>Дата:</strong><?=Shared::formatDate($row['created'])?></div>
<div class="left phone"><strong>Тел:</strong><?=Shared::formatPhone($row['phone'])?></div>
<div class="left operation_name"><strong>Операция:</strong><?=$row['name'] ?></div>
<div class="left advlink"><strong>Ссылка:</strong><a href="/advert/<?=$row['main_id'] ?>"><?=$row['main_id'] ?></a></div>
<div class="left upcount <?php if($row['upcount'] < 0):?> red <?php else:?> green <?php endif?>"><strong>Поднятий:</strong><?=$row['upcount']?></div>
<div class="left sum"><strong>Сумма пользователя:</strong><?=($row['sum'] ? $row['sum'] : '0' ) ?></div>
<div class="left approved <?=($row['pay_transaction_id'] ? 'green' : 'red') ?>"><strong>Заказ:</strong><?=$row['pay_transaction_id']?></div>
<div class="both"></div>
</div>
<?php endforeach?>

<?php if(count($ops->rows)): ?>
<div class="left">
		<a href="<?=setGetVar($_SERVER['REQUEST_URI'], 'page', $ops->prev )?>">&lt;</a>
</div>
<div style="float:left; width:100px;">&nbsp;</div>
<div class="left">
		<a href="<?=setGetVar($_SERVER['REQUEST_URI'], 'page', $ops->next )?>">&gt;</a>
</div>
<div style="clear:both"></div>
<?php endif ?>


</div><?php /* end operations */?>
<?php endif?>

