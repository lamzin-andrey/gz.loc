window.onload=function() {
	var d = document;
	var rows = d.getElementsByClassName('b3id-widget-table-data-row'), i;
	console.log(rows);
	var data = [];
	for (i = 0; i < rows.length; i++) {
		var tds = rows[i].getElementsByTagName('td');
		var price = tds && tds[2] && tds[2].innerText && tds[2].innerText.trim() ? parsePriceValue(tds[2].innerText.trim()) : -1.00;
		var operation = tds && tds[1] && tds[1].innerText && tds[1].innerText.trim() ? tds[1].innerText.trim() : '';
		if (operation.indexOf('Платеж') == -1) {
			continue;
		}
		
		if (price > 0) {
			console.log('P = ' + price);
			var date = tds && tds[0] && tds[0].innerText && tds[0].innerText.trim() ? parseDateValue(tds[0].innerText.trim()) : '';
			//TODO если это не конкретная дата, вернет пустую строку
			if (date) {
				data.push({
					price,
					date
				});
			}
		}
	}
	console.log(data);
	//здесь пароль смотреть в конфиге сайта в константе ADV_GATE_PWD
	//TODO проверить, не совпадает ли он с продакшеном!!!
	$.post('http://gz.loc/gatends', {'data' : data, 'pwd' : 'SXzpYE510M'}, ()=>{
		alert('Send success');
	});

}
/**
 * @param {String} s строка даты, на момент написания пример 21 нояб. 2018 г.
*/
window.parseDateValue = function(s) {
	console.log('parseDateValue GOT ' + s);
	var months = ['', 'янв.', 'февр.', 'мар.', 'апр.', 'мая', 'июн.', 'июл.', 'авг.', 'сент.', 'окт.', 'нояб.', ''], 
	i, j, a, day, month, year;
	for (i = 0; i < months.length; i++) {
		if (~s.indexOf(months[i])) {
			console.log('Found: ' + months[i]);
			a = s.split(months[i]);
			day = parseIntValue(a[0]);
			year = parseIntValue(a[1]);
			month = i > 9 ? i : ('0' + i);
			day = day > 9 ? day : ('0' + day);
			var res =  parseInt(year) + '-' + month + '-' + parseInt(day);
			console.log(res);
			return res;
		}
	}
	return '';
}
/**
 * @param {String} s строка цены, на момент написания −3 691,19 ₽
*/
window.parsePriceValue = function(s)
	{
		var allow = '0123456789-,.−', i, r = '', ch, 
			isPointAlready = 0,
			isMinusAlready = 0;
		s = String(s).trim();
		for (i = 0; i < s.length; i++) {
			ch = s.charAt(i);
			//console.log(ch);
			if (~allow.indexOf(ch)) {
				if (ch == ',') {
					ch = '.';
				}
				if (ch == '.') {
					if (!isPointAlready) {
						isPointAlready = 1;
					} else {
						continue;
					}
				}
				if (ch == '−') {
					ch = '-';
				}
				if (ch == '-') {
					if (!isMinusAlready) {
						isMinusAlready = 1;
					} else {
						continue;
					}
				}
				r += ch;
			}
		}
		//console.log(r);
		return parseFloat(r);
	}


/**
 * @param {String} s строка даты, на момент написания пример 21 нояб. 2018 г.
*/
window.parseDateValue = function(s) {
	console.log('parseDateValue GOT ' + s);
	if (String(s).indexOf('–') != -1) {
		return '';
	}
	var months = ['nicapius', 'янв.', 'февр.', 'мар.', 'апр.', 'мая', 'июн.', 'июл.', 'авг.', 'сент.', 'окт.', 'нояб.', ''], 
	i, j, a, day, month, year;
	for (i = 0; i < months.length; i++) {
		if (~s.indexOf(months[i])) {
			console.log('Found: ' + months[i]);
			a = s.split(months[i]);
			day = parseIntValue(a[0]);
			if (String(day).length > 2) {
				return '';
			}
			year = parseIntValue(a[1]);
			month = i > 9 ? i : ('0' + i);
			day = day > 9 ? day : ('0' + day);
			var res =  parseInt(year) + '-' + month + '-' + parseInt(day);
			console.log(res);
			return res;
		}
	}
	return '';
}
/**
 * @param {String} выбирает только целые числа из строки
*/
window.parseIntValue = function(s)
	{
		console.log('parseIntValue GOT ' + s);
		var allow = '0123456789', i, r = '', ch, 
			isPointAlready = 0,
			isMinusAlready = 0;
		s = String(s).trim();
		for (i = 0; i < s.length; i++) {
			ch = s.charAt(i);
			//console.log(ch);
			if (~allow.indexOf(ch)) {
				if (ch == ',') {
					ch = '.';
				}
				if (ch == '.') {
					if (!isPointAlready) {
						isPointAlready = 1;
					} else {
						continue;
					}
				}
				if (ch == '−') {
					ch = '-';
				}
				if (ch == '-') {
					if (!isMinusAlready) {
						isMinusAlready = 1;
					} else {
						continue;
					}
				}
				r += ch;
			}
		}
		console.log(r);
		return parseInt(r, 10);
	}
