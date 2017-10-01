// ==UserScript==
// @name        YaChecker
// @namespace   https://money.yandex.ru/history
// @include     https://money.yandex.ru/history
// @version     1
// @grant       none
//UserScript==

window.addEventListener('load', initYacApp, false);
window.Yacapp = {
  //КОНФИГ 
  siteApiURL : 'https://test.gazel.me',
  
  //СВОЙСТВА, ОТНОСЯЩИЕСЯ к процессу обработки истории платежей 
  /** Говорит о том, что подробные данные транзакции ещё не запрашивалисьу Яндекса.  */
  STEP_NO_INFO : 'STEP_NO_INFO',
  /** Шаг процесса обработки платежа  */
  notificationStep : 'STEP_NO_INFO',
  /** notificationStep принимает это значение, когда получены данные от Яндекса о деталях транзакции */
  STEP_INFO_EXISTS : 'STEP_INFO_EX'
  
  //СВОЙСТВА, ОТНОСЯЩИЕСЯ К РЕАЛИЗАЦИИ ЗАПРОСОВ к Яндексу
  
  //СВОЙСТВА, ОТНОСЯЩИЕСЯ К РЕАЛИЗАЦИИ ЗАПРОСОВ К сайту
};

function initYacApp() {
  Yacapp.procIterationIsRun = false;
  Yacapp.ival = setInterval(YacAppRun, 1 * 1000);
  //alert(1);
}
function YacAppRun() {
  if (Yacapp.procIterationIsRun) {
    return;
  }
  Yacapp.procIterationIsRun = true;
  console.log('bSendCross');
  sendCross({act:'ihere'});//TODO
  console.log('afSendCross');
  return;
  
  /*if (!Yacapp.firstTransactionDate) {
    sendCross({act:'getFirstTransaction'}, onFTISuccess);//TODO
    return;
  }
  if (Yacapp.firstTransactionDate) {
     if (!Yacapp.dateIsFound) {//Если у нас еще нет в истории платежей входящей операции с датой равной дате последнего оплаченного платежа или более ранней, ищем её.
       YacappGetHistory();
       return;
     }
     if (Yacapp.dateIsFound) {
       //сканируем известную историю, если найдены входящие платежи с датой более поздней, чем dateIsFound
       if (YacappIsExistsNewPaymentInHistory()) {//TODO 
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
       }else {
         //иначе запрашиваем новые элементы истории
         YacappGetNewItems();//TODO
         return;
       }
       
     }
  }*/
    
  Yacapp.procIterationIsRun = false;
}
/**
 * @description Отправляем запросы на наш сайт. Связь - через хеш ифрейма.
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
  form.submit();
  console.log('after submit');
  let ival = setInterval( function() {
     let s = e('YacappCrossConnector').src, a = String(s).split('#');
     if (a.length > 0 ) {
       clearInterval(ival);
       Yacapp.procIterationIsRun = false;
       if(onSuccess instanceof Function) {
        onSuccess(a[1]);
       }
     }
     
  }
  , 700);
}

function YacappGetHistory(){}
function YacappIsExistsNewPaymentInHistory(){}
function YacappGetOperationInfo(){}
function YacappGetNewItems(){}

// micron.js
window.D = document;
function e(i) {
	if (i && i.tagName || D == i) return i;
	return D.getElementById(i);
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
