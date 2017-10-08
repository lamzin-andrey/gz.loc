// ==UserScript==
// @name        YaChecker
// @namespace   https://money.yandex.ru/history
// @include     https://money.yandex.ru/history
// @include     https://money.yandex.ru/actions
// @version     1
// @grant       none
//UserScript==

window.addEventListener('load', initYacApp, false);
window.Yacapp = {
  //КОНФИГ 
  //nen закрывающий слеш обязательный.
  siteApiURL : 'https://samsungmobyle.comxa.com/temp/yagate/',
  siteApiResponseURL : 'https://samsungmobyle.comxa.com/temp/yagate/answ.js',
  
  //СВОЙСТВА, ОТНОСЯЩИЕСЯ к процессу обработки истории платежей 
  /** Говорит о том, что подробные данные транзакции ещё не запрашивалисьу Яндекса.  */
  STEP_NO_INFO : 'STEP_NO_INFO',
  /** Шаг процесса обработки платежа  */
  notificationStep : 'STEP_NO_INFO',
  /** notificationStep принимает это значение, когда получены данные от Яндекса о деталях транзакции */
  STEP_INFO_EXISTS : 'STEP_INFO_EX',
  
  //СВОЙСТВА, ОТНОСЯЩИЕСЯ К РЕАЛИЗАЦИИ ЗАПРОСОВ к Яндексу
  HISTORY_OFFSET : 0,
  aHistory : [],
  
  //СВОЙСТВА, ОТНОСЯЩИЕСЯ К РЕАЛИЗАЦИИ ЗАПРОСОВ К сайту
};

function initYacApp() {
  if (Yacapp.isInit) {
    return;
  }
  Yacapp.procIterationIsRun = false;
  Yacapp.ival = setInterval(YacAppRun, 1 * 1000);
  Yacapp.isInit = true;
  alert(1);
}
function YacAppRun() {
  if (Yacapp.procIterationIsRun) {
    return;
  }
  Yacapp.procIterationIsRun = true;
  
  if (!Yacapp.firstTransactionDate) {
    sendCross({act:'getFirstTransaction'}, onFTISuccess);
    return;
  }
  if (Yacapp.firstTransactionDate) {
     if (!Yacapp.dateIsFound) {//Если у нас еще нет в истории платежей входящей операции с датой равной дате последнего оплаченного платежа или более ранней, ищем её.
       //Тут ищем платежи с датой как у firstTransactionDate или более раннии
       YacappGetHistory();
       return;
     }
     if (Yacapp.dateIsFound) {
       //сканируем известную историю, если найдены входящие мобильные платежи с датой более поздней, чем dateIsFound
       if (YacappIsExistsNewPaymentInHistory()) {
         //Отправляем нам нотайс.
         //Yacapp.unprocessPaymentId
         if (Yacapp.notificationStep == Yacapp.STEP_NO_INFO) {
          YacappGetOperationInfo();//TODO получаем подробную информацию о транзакции у Яндекса
          return;
         }
         if (Yacapp.notificationStep == Yacapp.STEP_INFO_EXISTS) {
           sendCross({act:'savePaymentData'}, onSavePData);//firstTransactionDate - перезаписать
           return;
         }
       } else {
         //иначе запрашиваем новые элементы истории
         YacappGetNewItems();//TODO
         return;
       }
       
     }
  }
    
  Yacapp.procIterationIsRun = false;
}
/**
 * @description сканируем известную историю, если найдены входящие мобильные платежи с датой более поздней, чем dateIsFound
 * @return {Booleean} true
*/
function YacappIsExistsNewPaymentInHistory() {
	var i = 0, sz = Yacapp.aHistory.length, c;
	for (i = sz - 1; i > -1; i--) {
		c = Yacapp.aHistory[i];
	}
}
/**
 * @description Тут ищем платежи с датой как у firstTransactionDate или более раннии 
*/
function YacappGetHistory() {
	var n = Yacapp.HISTORY_OFFSET;
	var url = 'https://money.yandex.ru/ajax/history/partly?ncrnd=2335&history_shortcut=history_all&search=&start-record=' + n + '&record-count=20';
	_get(YacappOnHistory, url);
}
/**
 * Обработка ответа с серверов Яндекса с историей платежей
*/
function YacappOnHistory(data) {
	console.log(data);
	var i, cday, cdate,
		firstDate = Yacapp.firstTransactionDate.replace(' ', 'T') + '.756+0300';
	firstDate = new Date(firstDate).getTime();
	if (data.success && data.history) {
		for (i = 0; i < data.history.length; i++) {
			cday = data.history[i];
			if (cday.type != 4) {
				continue;
			}
			cdate = new Date(cday.date).getTime();
			console.log(cdate);
			console.log(firstDate);
			Yacapp.aHistory.push(cdate);
			if (cdate <= firstDate) {
				console.log('Найдена более ранняя чем последняя оплаченная транзакция');
				console.log(cday);
				Yacapp.dateIsFound = cdate;
				Yacapp.procIterationIsRun = false;
				break;
			}
		}
	}
	Yacapp.HISTORY_OFFSET += 20;
}
/**
 * @description Записать в память время последнего оплаченного платежа
*/
function onFTISuccess(dt) {
	Yacapp.firstTransactionDate = dt;
	Yacapp.procIterationIsRun = false;
}
/**
 * @description Отправляем запросы на наш сайт. Связь туда через ифрейм, оттуда через js с сайта.
*/
function sendCross(data, onSuccess) {
  console.log('Enter');
  if (Yacapp.crossRequestIsSended) {
    return;
  }
  console.log('11');
  Yacapp.crossRequestIsSended = true;
  let iframe = e('YacappCrossConnector'), form;
  console.log('112');
  if (iframe) {
    console.log('bef rm');
   iframe.parentNode.removeChild(iframe);
  }
  console.log('bef html create');
  let html = `
  <form method="POST" action="${Yacapp.siteApiURL}" id="YacappCrossForm" target="YacappIframe" style="display:non;">
  </form>
  <input type="hidden" id="ianswer">
<iframe src="${Yacapp.siteApiURL}" id="YacappIframe" style="display:non;" name="YacappIframe"></iframe>`;
  
  appendChild(document.getElementsByTagName('body')[0], 'div', html, {id: 'YacappCrossConnector'});
  console.log('after inuit html var');
  form = e('YacappCrossForm');
  form.innerHTML = '';
  for (let i in data) {
    appendChild(form, 'input', '', {name:i, id:i, value:data[i], type:'hidden'});
  }
  console.log('after call appendChild');
  //console.log(form);
  e('ianswer').value = '';
  form.submit();
  console.log('after submit');
  var IC = 0;
  let ival = setInterval( function() {
	  IC++;
	  if (IC > 10) {
		clearInterval(ival);  
	  }
	  appendChild(document.getElementsByTagName('head')[0], 'script', '', {
		src: Yacapp.siteApiResponseURL + '?r' + Math.random(),
		'data-lbl' : 'tmpscr'
		});
	  var v = e('ianswer').value;
     if (v ) {
       clearInterval(ival);
       console.log('End request, r = "' + v + '"');
       var scripts = document.getElementsByTagName('head');
       for (var jk = 0; jk < scripts.length; jk++) {
		   if(scripts[jk].hasAttribute('data-lbl')) {
			   rm(scripts[jk]);
		   }
	   }
       Yacapp.crossRequestIsSended =  false;
       if(onSuccess instanceof Function) {
			onSuccess(v);
       }
     }
  }
  , 3*1000);
  
}

function YacappIsExistsNewPaymentInHistory(){}
function YacappGetOperationInfo(){}
function YacappGetNewItems(){}

// micron.js
window.D = document;
function e(i) {
	if (i && i.tagName || D == i) return i;
	return D.getElementById(i);
}
function rm(n) {
	n = e(n);
	n.parentNode.removeChild(n);
}
function appendChild(parent, tag, innerHTML, obj, dataObj) {
	var el = D.createElement(tag), i;
	if (obj) {
		for (i in obj) {
			if (obj[i] instanceof Function) {
				el[i] =  obj[i];
			} else {
				el.setAttribute(i, obj[i]);
			}
		}
	}
	if (dataObj) {
		for (i in dataObj) {
			el.setAttribute('data-' + i, dataObj[i]);
		}
	}
  console.log(innerHTML);
	el.innerHTML = innerHTML;
	e(parent).appendChild(el);
}

//ajax.js

function _get(onSuccess, url, onFail) {
	_restreq('get', {}, onSuccess, url, onFail)
}
function _delete(onSuccess, url, onFail) {
	_restreq('post', {}, onSuccess, url, onFail)
}
function _post(data, onSuccess, url, onFail) {
	var t = getToken();
	if (t) {
		data._token = t;
		_restreq('post', data, onSuccess, url, onFail)
	}
}
function _patch(data, onSuccess, url, onFail) {
	_restreq('patch', data, onSuccess, url, onFail)
}
function _put(data, onSuccess, url, onFail) {
	_restreq('put', data, onSuccess, url, onFail)
}
function _restreq(method, data, onSuccess, url, onFail) {
	/*$('#preloader').show();
	$('#preloader').width(screen.width);
	$('#preloader').height(screen.height);
	$('#preloader div').css('margin-top', Math.round((screen.height - 350) / 2) + 'px');
	*/
	if (!url) {
		url = window.location.href;
	} else {
		url = url;
	}
	if (!onFail) {
		onFail = defaultFail;
	}
	switch (method) {
		case 'put':
		case 'patch':
		case 'delete':
			break;
	}
	/*$.ajax({
		method: method,
		data:data,
		url:url,
		dataType:'json',
		success:onSuccess,
		error:onFail
	});*/
	pureAjax(url, data, onSuccess, onFail, method);
}

function defaultFail() {
	alert('Видимо что-то случилось');
}

/**
 * @desc Аякс запрос к серверу, использует JSON
*/
function pureAjax(url, data, onSuccess, onFail, method) {
	var xhr = new XMLHttpRequest();
	//подготовить данные для отправки
	var arr = []
	for (var i in data) {
		arr.push(i + '=' + encodeURIComponent(data[i]));
	}
	var sData = arr.join('&');
	//установить метод  и адрес
	//console.log("'" + url + "'");
	xhr.open(method, url);
	//console.log('Open...');
	//установить заголовок
	xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	//обработать ответ
	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4) {
			var error = {};
			if (xhr.status == 200) {
				try {
					var response = JSON.parse(String(xhr.responseText));
					onSuccess(response, xhr);
					return;
				} catch(e) {
					console.log(e);
					error.state = 1;
					error.info = 'Fail parse JSON';
				}
			}else {
				error.state = 1;
			}
			if (error.state) {
				onFail(xhr.status, xhr.responseText, error.info, xhr);
			}
		} else if (xhr.readyState > 3) {
			onFail(xhr.readyState, xhr.status, xhr.responseText, 'No ok', xhr);
		}
	}
	//отправить
	//console.log('bef send');
	xhr.send(sData);
	//console.log('aft send');
}
