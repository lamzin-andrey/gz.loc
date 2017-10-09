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
		var url = 'https://auth.robokassa.ru/Merchant/PaymentForm/FormFLS.js?', i, scr;
		for (i in data.rkData) {
			url += (i + '=' + data.rkData[i] + '&');
		}
		alert(url);
		scr = document.createElement('script');
		scr.src = url.replace(/&$/, '');
		$('hRoboplace').appendChild(scr);
		$('hPaysumGr').addClass('hide');
		$('hPaymethodGr').addClass('hide');
		$('hRoboplace').removeClass('hide');
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
