window.n = 0;
window.fm = 'Сбой при определении параметров оплаты, обновите страницу и попробуйте ещё раз';
$(document).addEvent('domready', pInit); 
function pInit() {
	$("hPaysumGr").getElements("div").each(function(i){
			i.onclick = onPSumBtnClick;
		}
	);
	$("hPaymethodGr").getElements("div").each(function(i){
			i.onclick = onPMBtnClick;
		}
	);
}
function onPMBtnClick() {
	var t = this, q = $(t).getElements('input')[0].id, h = {yad:'ps', card: 'bs', mob:'ms'};
	q = h[q];
	if (q && window.n) {
		$(q).checked = true;
		Tool.post("/paycheck", {q:q, n:n, r: $(rec).value}, onCheckPayPublic, onCheckPayError);
	} else {
		alert(fm);
	}
}
function onCheckPayPublic(data) {
	if (to_i(data.id) > 0) {
		if (!data.rkData) {
			$('label').value = $('transactionId').value = to_i(data.id);
			data.sum = 10;
			$('sum').value = data.sum;
			$(data.q).checked = true;
			$('yaform').submit();
			return;
		}
		var url = 'https://auth.robokassa.ru/Merchant/PaymentForm/FormFLS.if?', i, scr, iW = 380, iH = 70;
		for (i in data.rkData) {
			url += (i + '=' + data.rkData[i] + '&');
		}
		scr = document.createElement('iframe');
		scr.src = url.replace(/&$/, '');
		scr.setAttribute('style', 'border:0;width:' + iW + 'px;height:' + iH + 'px;overflow:hidden;background-color:transparent;');
		scr.setAttribute('allowTransparency', 'true');
		scr.setAttribute('width', iW);
		scr.setAttribute('height', iH);
		scr.setAttribute('scrolling', 'no');
		$('hRoboplace').appendChild(scr);
		$('hPaysumGr').addClass('hide');
		$('hPaymethodGr').addClass('hide');
		$('hRoboplace').removeClass('hide');
		/*
		document.write("<iframe width=\"450\" height=\"70\" 
		style=\"\" 
		allowTransparency=\"true\" 
		src=\"https://auth.robokassa.ru/Merchant/PaymentForm/FormFLS.if?
		MrchLogin=gazelme&OutSum=700&InvId=26&IncCurrLabel=rur&Desc=%D0%9E%D0%BF%D0%BB%D0%B0%D1%82%D0%B0%20%D0%B2%D0%BE%D0%B7%D0%BC%D0%BE%D0%B6%D0%BD%D0%BE%D1%81%D1%82%D0%B8%20%D0%BF%D0%BE%D0%B4%D0%BD%D1%8F%D1%82%D1%8C%20%D0%BE%D0%B1%D1%8A%D1%8F%D0%B2%D0%BB%D0%B5%D0%BD%D0%B8%D0%B5%20%D0%BD%D0%B0%20gazel.me&SignatureValue=8ecf1dac8a72464727716c212a49b04b&Shp_item=1&Culture=null&Encoding=null&isTest=1\"></iframe>");*/
	}
}
function onCheckPayError() {
	alert(fm);
}
function onPSumBtnClick(evt) {
	var t = this, s = $(t).getElements('input')[0].id.replace('s', ''), q = 0, g;
	n = parseInt(s, 10);
	if (n && n == 60 || n == 200 || n == 700) {
		$('nSum').innerHTML = n;
		$('hPaysumGr').addClass('hide');
		$('hPaymethodGr').removeClass('hide');
		switch (n) {
			case 60:
				q = 1;
				break;
			case 200:
				q = 5;
				break;
			case 700:
				q = 31;
				break;
		}
		g = $('comment').value.replace('{n}', q);
		$('comment2').value = $('comment').value = g;
	} else {
		alert('Некорректная сумма!');
	}
}
