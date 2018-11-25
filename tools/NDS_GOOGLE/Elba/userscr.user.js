// ==UserScript==
// @name        ElbaGoogleNDSFormFiller
// @namespace   https://elba.kontur.ru/Business/Documents/DocumentEditing/*
// @include     https://elba.kontur.ru/Business/Documents/DocumentEditing/*
// @version     1
// @grant       none
// ==/UserScript==

function e(i) {return document.getElementById(i);}

function ee(tag, parent) {
  if (!parent) {
      parent = document;
  }
  return parent.getElementsByTagName(tag);
}

function eee(tag, parent, callback) {
  var ls = ee(tag, parent), i;
  for (i = 0; i < ls.length; i++) {
     callback(ls[i]);
  }
}
function trim(s) {
	s = s.replace(/^\s+/, '');
	s = s.replace(/\s+#/, '');
	return s;
}
var w = window, d = document, b = d.body, wlh = w.location.href;

w.onload = function() {
	w.onkeypress = b.onkeypress =  aviOnKeyPress;
  
  
  /*setInterval(()=>{
    var bd = b, ls, i, buf = [], sz;
    ls = document.getElementsByClassName('b-popups');
    sz = ls.length;
    for (i = sz - 1; i > -1; i--) {
      ls[i].onkeypress = aviOnKeyPress;
    }
    ls = document.getElementsByClassName('b-popup-overlay');
    sz = ls.length;
    for (i = sz - 1; i > -1; i--) {
      ls[i].onkeypress = aviOnKeyPress;
    }
    
    ls = document.getElementsByClassName('popup-content');
    sz = ls.length;
    for (i = sz - 1; i > -1; i--) {
      ls[i].onkeypress = aviOnKeyPress;
    }
  }, 500);*/
	
  /*(function(){var D=document,W=window;function $(i){if(i&&i.tagName||D==i){return i}return D.getElementById(i)}function $$(p,c){p=$(p);return p.getElementsByTagName(c)}function hasClass(obj,css){var obj=$(obj);var c=obj.className,_css=css.replace(/\-/g,"\\-"),re1=new RegExp("^\\s?"+_css+"\\s*"),re2=new RegExp("\\s+"+_css+"(\\s+[\\w\\s]*|\\s*)$");if(c==css||re1.test(c)||re2.test(c)){return true}return false}function removeClass(obj,css){obj=$(obj);var c=obj.className,re=/[0-9a-zA-Z\-_]+/gm,arr=c.match(re),i,result=[];if(arr){for(i=0;i<arr.length;i++){if(arr[i]!==css){result.push(arr[i])}}}obj.className=result.join(" ")}function addClass(obj,css){obj=$(obj);removeClass(obj,css);obj.className+=" "+css}window.getViewport=function(){var w=W.innerWidth,h=W.innerHeight;if(!w&&D.documentElement&&D.documentElement.clientWidth){w=D.documentElement.clientWidth}else{if(!w){w=D.getElementsByTagName("body")[0].clientWidth}}if(!h&&D.documentElement&&D.documentElement.clientHeight){h=D.documentElement.clientHeight}else{if(!h){h=D.getElementsByTagName("body")[0].clientHeight}}return{w:w,h:h}};W.appWindow=function(id,s,onclose,clear){var bgId="popupbg",winId="popup",current="current_wnd_content",content="appWindowPopup",tmp,winW,winH,vp=getViewport(),w=vp.w,h=vp.h;appWindowClose();W.appCloseCallback=onclose;if(!$(id)){return}if(clear){var ls=$$(id,"input"),i,lt=$$(id,"textarea");for(i=0;i<(ls.length>lt.length?ls.length:lt.length);i++){if(ls[i]&&ls[i].name!="authenticity_token"){if(ls[i].type!="checkbox"&&ls[i].type!="button"&&ls[i].type!="submit"){ls[i].value=""}else{ls[i].checked=false}}if(lt[i]){lt[i].value=""}}}$(winId).style="";$(content).style="";if(s){$("popuptitle").innerHTML=s}$(winId).style.opacity=0;removeClass(bgId,"hide");removeClass(winId,"hide");tmp=D.createElement("div");$$(D,"body")[0].appendChild(tmp);tmp.id=current;swapNodes(id,tmp);removeClass(id,"hide");removeClass(content,"scrollx");removeClass(content,"scrolly");$(content).appendChild($(id));$(id).opacity=0;winW=$(winId).offsetWidth;winH=$(winId).offsetHeight;if(winW<w&&winH<h){with($(winId).style){left=Math.round((w-winW)/2)+"px";top=Math.round((h-winH)/2)+"px"}}else{with($(winId).style){left="0px";top="0px";width="100%";height=h+"px";overflowX="scroll";overflowY="scroll"}}if($(id).offsetWidth>$(content).offsetWidth){addClass(content,"scrollx");$(content).style.maxWidth=(w-5)+"px"}if($(id).offsetHeight>(h-35)){addClass(content,"scrolly");$(content).style.maxHeight=(h-40)+"px"}with($(bgId).style){width=w+"px";height=h+"px"}$(winId).style.opacity=1;$(id).setAttribute("data-srcid",id);$(id).id="execute_block"};W.swapNodes=function(b1,b2){b1=$(b1);b2=$(b2);var t=D.createElement("i"),p1=b1.parentNode,p2=b2.parentNode;p1.replaceChild(t,b1);p2.replaceChild(b1,b2);p1.replaceChild(b2,t);delete t};window.appWindowClose=function(){var bgId="popupbg",winId="popup",current="current_wnd_content",execute="execute_block",old=$(execute);addClass(bgId,"hide");addClass(winId,"hide");if($(current)){if(old){old.id=old.getAttribute("data-srcid");swapNodes(current,old);addClass(old,"hide")}$(current).parentNode.removeChild($(current))}if(W.appCloseCallback instanceof Function){W.appCloseCallback()}};W.showLoader=function(){var bgId="loaderbg",ldId="ldrbig",vp=getViewport(),w=vp.w,h=vp.h;removeClass(bgId,"hide");with($(bgId).style){width=w+"px";height=h+"px"}removeClass(ldId,"hide");with($(ldId).style){opacity=0;left=Math.round((w-$(ldId).offsetWidth)/2)+"px";top=Math.round((h-$(ldId).offsetHeight)/2)+"px";opacity=1;position="absolute"}};W.hideLoader=function(){addClass("ldrbig","hide");addClass("loaderbg","hide")};function addResources(){addCss();addHtml()}function addCss(){var style=D.createElement("style");style.innerHTML='.hide{display:none}.popupbg{background:url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACwAAAAsCAYAAAAehFoBAAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAAN1wAADdcBQiibeAAAABl0RVh0U29mdHdhcmUAd3d3Lmlua3NjYXBlLm9yZ5vuPBoAAABQSURBVFiF7c5BDYAwAACxMa3zghMc8p+GPRpCclXQ637eNX5kfh04VVgrrBXWCmuFtcJaYa2wVlgrrBXWCmuFtcJaYa2wVlgrrBXWCmuFtQ0cEALewERBRQAAAABJRU5ErkJggg==") repeat;position:fixed;width:100%;left:0;top:0;z-index:1}.adminpopup{background-color:#d7d8f3;background:linear-gradient(to bottom,#80a8d1,#478bd2);border-radius:9px 9px 0 0;border:1px solid #c3d1d7;min-width:250px;z-index:2;position:fixed;left:0;top:0;color:black;box-shadow:3px 7px 5px 0 #a0bac7}#popuptitle{float:left;font-weight:bold;margin:7px 0 0 21px;color:white}.popup-close{float:right;margin:6px 14px 0 8px;cursor:pointer}.popup-close img{width:24px;height:24px}.popup-content{background-color:white;margin:0 6px 4px 6px;overflow:hidden}.scrolly{overflow-y:scroll !important}.scrollx{overflow-x:scroll !important}.tmce{width:100%}.w700{min-width:700px}#ldrbig{position:absolute}.z6{z-index:6 !important}img.loader{z-index:7;position:fixed}.both{clear:both}';D.head.appendChild(style)}function addHtml(){s='<div class="adminpopup hide" id="popup"><div class="popup-title-area"><div id="popuptitle">..</div><div class="popup-close" id="closeOut"><img id="closeIn" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAABHNCSVQICAgIfAhkiAAAABl0RVh0U29mdHdhcmUAd3d3Lmlua3NjYXBlLm9yZ5vuPBoAAASRSURBVFiF5ZfLbxNXFMZ/4xkn8fhFggQOCbFDNpUq1ATRsimq6C6ikD6QEEFABQjKpkLECv0T2kW6KFJt51VFlFUX/AVdVBWqKlh00QoECfYkTgTOy87Y49d4bhfEbiAeJ62CWPRIdzPfnfOd851zz52RhBC8SXO8UXZAAfjk7NkO4BvgA6DzNXMmgV+Am3fv3JmXPh4c3A/8AbQB+P1+ukMhHI6dFceyLOKJBJlMpvpoBehVgBGgzev18tXQEN1dXTtK/KrFZ2f5emQEXdfbgBH5rYMHvwM84evXORAMYlnWa10+r5eenh5+vXcPYLcCBFRVJRQMUiyXKZbLmKbJTp8NCVAUhWank1AwiKqqGIYRUAA6OzoolErouRwVy7J1ktV1JIcDt9tdF88bBma5jNfvt/UhOxx43W46Ozp4/OTJi1MggLVsFrNSsSfPZpkYG6OpqYnPL17E5XK9hBfyeaampsjlcly+fBmfTRCWZbGWzdYUdgCUSiXKpokQou7S19YYjcV4lkoxm0wyOT6OYRg1PG8Y/DA5SULTWFxaYnR0lHQ6beuvbJqUSqV/AjBN07Zp9EyGaDTKs+fPqVQqVCoVtLk5JsbGMAwDwzCYnJggrmk1PLW4SCwaJbOyYuvXNE1gfRBVpdkku64zGouRWlrahCVmZxkfG0MCtLm5TXhqcZHvo1GuXr1qW45aAEKIugFIQmDk81RseiOeSNg6BigUCrCe8atWvYNq466eTM2qynA4zO62tn993lt37WL4xg1Ur7cuXjXHRgXqbpRlhoeGaA8EajXeagX27OFmOIzU1GTrd1sKVFfJshgeGqI7GNySPNTVxXA4TLlBUhsVqDXhVt8Fy+k0+ULBth9qdS8WWU6ncalqw33bLoFlWRi5HLFolISmbVn7hKYRjUTIZbMN9227BFXymXh82z0Q1zQikQhZXd+yBA0VKBYKxKJRpp8+3TZ5LYhEgmgkQt4w/rsCnYEAPQcO2JJ8evIknw0M2OLdoRD7A4Gtm1BQfxLOp1J8ceUKqsvFT3fvvoRdPHeOj06cAMCtqoxPTb2EDxw/zqVLl4jXmZJVzloA2ExCgGlN48L587hVlcnbtwH48to1jh07hjY/D0B/fz8ej4dvb90C4Ozp0wyeOcO0ptX1WeWsBeBwOLCEQLLZ+zge59SpU6iqisfj4b0jR9AWFmq4trDA+0eP4nG7eZ5KMTAwwON43J57nRNAkWUZSZbJGwYtLS22Lz2amaG/v59CsUgimdyEJ5JJ3unro6W5mUczM/aZ8+KOcMgyTkVB8Xm9wjJNKbO2RqFQQFVVZFlGkjbr8XB6uqFju3rDi5NWqVQwDINiqYSwLHw+n1D2BQKpxeXlvdlslpwksbK62pBkJ0ysl3tfe3tKOdzXN/Pb/ft708vLKE4n1Ml8h9kR67fl4d7ep9JfDx/2rqbTP//+4EGbaZqYQjT8NtyO1U1BkpBlmRZFwel08u6hQ6u7/P4PJSEESysrb+u6/mO5XG5HCJfY0ACN9KjXJxsJ674vSXmnLC/4vN5zra2tf0r/+7/jvwEDrW44yW5LnAAAAABJRU5ErkJggg==" /></div></div><div class="both"></div>		<div class="popup-content" id="appWindowPopup"></div></div><div class="popupbg hide"id="popupbg"></div>';if(D.body){D.body.innerHTML=D.body.innerHTML+s}else{D.write(s)}}addResources()})();
	
  b.innerHTML += '<div id="reportwindow" class="hide"><form action="' + w.uact + '" method="POST" enctype="multipart/form-data" target="_blank">'
	+
  '<textarea id="iBody" name="iBody" style="resize:none;width:650px;height:250px" rows="5"></textarea>' +
  '<input type="button" id="bSetData" value="Save to localStorage">';
  
  e('closeOut').onclick = appWindowClose;
	e('closeIn').onclick = appWindowClose;  
  e('bSetData').onclick = setDataToLocalStorage;*/
}
function aviOnKeyPress(evt) {
	if(evt.code == 'KeyC' && evt.ctrlKey) {
		createExportForm();
	}
  if(evt.code == 'KeyV' && evt.ctrlKey) {
		fillFormRecordData();
	}
}
function createExportForm() {
  appWindow('reportwindow', 'Hello', function(){});
}
/**
 * Получает данные из хранилища и находит одну не сохраненную. Найдя, запускает fillConcreteRecord
*/
function fillFormRecordData(){
  if (window.ndsProcessIsRun) {
    return;
  }
  window.ndsProcessIsRun = true;
  var v = localStorage.getItem('adwordsndsrows');
  try {
    data = JSON.parse(v);
  } catch(e){;};
  if (!data) {
    alert('Ни хрена там нет, парень!');
    return;
  }
  var i, row;
  console.log(data);
  for (i = 0; i < data.length; i++) {
    row = data[i];
    if (row.is_public == '0') {
      fillConcreteRecord(row);
      v = JSON.stringify(data);
      localStorage.setItem('adwordsndsrows', v);
      return;
    }
  }
  
}
/**
 * Заполняет форму ввода данными (полученными из квитанции гугла, то есть нет номера чека)
*/
function fillConcreteRecord(o) {
  if (~o.payment_date.indexOf('2018-11')) {
    //var data = prepareDataForSend(o);
  	console.log(o);
    o.is_public = 1;
    return;
  }
  var data = prepareDataForSend(o);
  console.log(data);
  pureAjax('/Business/Documents/DocumentEditing/EditDocument/Save?scope=jjwozy8qe2w3kbr5y0tskq', data, 
           function(data){
    			 	alert('Success');
    				console.log(data);
  				 }, function(){console.log(arguments);}, 'POST'); 
  
}

function prepareDataForSend(o) {
  //o.payment_date = '2018-11-15';
  var dt = new Date(), 
      sName = getSName(o), //TODO "Рекламные услуги Google AdWords от 11 ноября 2018\nПредоплата 100%. \t150,00\nНДС 18/118 22,88"
     //TODO внимательно! Отправь форму вручную, чтобы убедиться, что всё ок и FromContractor совпадает!
     sFormCont = "d857d97d-7f6a-40ac-9c70-081515b8b6dd",
      aDocDate = o.payment_date.split('-'),
      targetMonth = '',
      nTargetMonth = parseInt(aDocDate[1], 10);
  		console.log('Распарсили ' + aDocDate[1]);
  		console.log('Get ' + nTargetMonth);
      nTargetMonth--;
  		console.log('After dec ' + nTargetMonth);
  
  var data = {
    "Scheduler":{
    	"MonthDay":new Date().getDate(),
      
      "IsLastWorkingDay":false, "StartDate":null, "IsScheduleTemplate":false, 
//TODO несмотря на то, что выбрал в инпуте 11 11 2018 и это сохранилось даже при редактировании, значит сюда именно текущую
"NextCreationDate":new Date(dt.getFullYear(), dt.getMonth(), dt.getDate(),0,0,0,0),

"CreateTemplate":false, "AdjustMonth":false}, 
    
    "Document":{"Number": parseInt(e('Number').value), "Title":null, 

"Date":new Date(parseInt(aDocDate[0]), nTargetMonth, parseInt(aDocDate[2]),13,0,0,0), //Вот тут странно, почему 10 - нормально, это как в js getMonth()

 "Comment":null, "Employee":null, "EmployeeId":null, "Type":3, "WriteOffType":null, 
"DealId":"6dc54107-2afe-4837-9dcd-0b0b57120bb7",
"BankAccountId":null, "ContractorId":"00000000-0000-0000-0000-000000000000",
"ContractorBankAccountId":null, "Status":null, "WithDiscount":false, "WithNds":true, "IsSumWithNdsView":true,
"ConsigneeId":null, "ConsigneeBankAccountId":null, "ContentTemplate":null,
"PaymentDocumentDate":undefined, "PaymentDocumentNumber":undefined, 

"FromContractor":sFormCont,
//"FromContractor":"d857d97d-7f6a-40ac-9c70-081515b8b6dd",
//а предыдущий    d857d97d-7f6a-40ac-9c70-081515b8b6dd - бинго!!!!!
                                                          
"PrincipalId":null, "NdsOperationType":7, "SellerInvoiceNumber":null, "DocumentImages":[],
"CustomTemplateId":null, "IsTemplate":false, "AssetId":null, "CorrespondingAccountKey":null, "AcceptanceType":null,
"CustomPlaceholders":[],
"StateContractIdentifier":null,
"FromOurOrganization":true,
"ContractorIsOurOrganization":false,
"OrganizationId":"00000000-0000-0000-0000-000000000000",
"TimestampOnSave":true,
"Id":"00000000-0000-0000-0000-000000000000",
"Revision":0, "Deleted":false,
"Updated":0,
"Created":null,
"Tags":null,
"IsTopRevision":null},
"Items":[{"Id":null, 
"Name":sName,
"Quantity":1, "Unit":"услуга", "Price":o.payment_sum, "Discount":0, 
"SumWithNds":o.payment_sum, "NdsRate":3}]
};
  return data;
}

function getSName(o) { //TODO "Рекламные услуги Google AdWords, оплачены 11 ноября 2018\nПредоплата 100%. \t150,00\nНДС 18/118 22,88"
  console.log(o);
  var tpl = "Рекламные услуги Google AdWords оплачены {dtdot}\nПредоплата 100%. \t{price}\nНДС 18/118 {nds18}";
  var a = o.payment_date.split('-');
  a = a.reverse();
  var sd = a.join('.');
  var s = tpl.replace('{dtdot}', sd);
  console.log(s);
  console.log(tpl);
  var nds18 = -1*( (o.payment_sum / 1.18) - o.payment_sum);
  nds18 = round(nds18, 2);
  nds18 = String(nds18).replace('.', ',');
  console.log(nds18);
  s = s.replace('{nds18}', nds18);
  var price = String(o.payment_sum).replace('.', ',');
  if (price.indexOf(',') == -1) {
    price += ',00'
  }
  s = s.replace('{price}', price);
  return s;
}

function setDataToLocalStorage() {
  var v = e('iBody').value;
  var data = null;
  try {
    data = JSON.parse(v);
  } catch(e){;};
  if (!data) {
    return;
  }
  window.localStorage.setItem('adwordsndsrows', v);
}

//========libs=====
   //тут будем считать что победили, надо отправлоять ajax-ом
  function pureAjax(url, data, onSuccess, onFail, method) {
    console.log("I call '" + url + "'");  
    var xhr = new XMLHttpRequest();
    //подготовить данные для отправки
    /*var arr = []
    for (var i in data) {
      arr.push(i + '=' + encodeURIComponent(data[i]));
    }
    var sData = arr.join('&');*/
    var sData = JSON.stringify(data);
    //установить метод  и адрес
    console.log("'" + url + "'");
    xhr.open(method, url);
    //console.log('Open...');
    //установить заголовок
    //xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.setRequestHeader('Content-Type', 'application/json');
    //обработать ответ
    xhr.onreadystatechange = function() {
      if (xhr.readyState == 4) {
        var error = {};
        if (xhr.status == 200) {
          try {
            //var response = JSON.parse(String(xhr.responseText));
            onSuccess(xhr.responseText, xhr);
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
          console.log('Ye it here!');
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
function round(float, per) {
	if (!per) {
		return Math.round(float);
	}
	var n = 1, i;
	for (var i = 0; i < per; i++) {
		n *= 10;
	}
	return Math.round(float * n) / n;

}
function getSelectedText(sel) {
	if (!sel || !sel.tagName == 'SELECT') {
		return '';
	}
	var o = getOptionByValue(sel, sel.value);
	if (o && o.text) {
		return o.text;
	}
	return '';
}
function getOptionByValue(select, n) {
	var i, ls = select.getElementsByTagName('option');
	for (i = 0; i < ls.length; i++) {
		if ( ls[i].value == n ) {
			return ls[i];
		}
	}
	return null;
}
