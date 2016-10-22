// ==UserScript==
// @name        TestValuesForForm
// @namespace   http://gz.loc/podat_obyavlenie
// @include     http://gz.loc/podat_obyavlenie
// @version     1
// @grant       none
// ==/UserScript==

window.onload=main;
function main() {
  //set region
  if (region.value == 0) {
    for (i = 0; i < region.options.length; i++) {
        if(region.options[i].value > 0) {
            region.options[i].selected = true;
            break;
        }
    }
  }
  
  //set checkboxes
  people.checked = true;
  far.checked = true;
  title.value = 'Тестовое объявление';
  addtext.value = 'Ghjlfv ckjyf';
  price.value = '1000';
  document.getElementById('name').value = 'Skitnick';
  phone.value = '+79187353657';
  agreement.checked = true;
  cp.focus();
  window.scrollTo(0, 10000);
}
