<?php
#================ db====================================================
mysql_pconnect("localhost", "user", "*****") or die('connect error');
mysql_select_db("gz") or die('error select db gz');
mysql_query("SET NAMES UTF8");
#================ constant==============================================
define("DR", $_SERVER["DOCUMENT_ROOT"]);
define("TPLS", DR . '/tpl');
define("MAX_WIDTH", 240);
define("MAX_HEIGHT", 240);
define("ADMIN_PHONE", '000000');
define('SITE_EMAIL', '***@**.ru');
define('NOTICE_EMAIL', '***@***.ru');
define('SITE_NAME', 'gazel.me');
define("H1_BEG", "Заказ ГАЗели в ");
define('AUTO_MODERATION_ON', true);
define('MONTH_IN_SEC', 30*24*3600);

define('SMS_INTERVAL', 63);//product 900
define('SMS_SERVICE_ON', true);
define('SMS_SERVICE_LOGIN', '****');
define('SMS_SERVICE_PASSWORD', '***');

define('SMS_PILOT_API_KEY', '*****');

define('ASSETS_VERSION', '12');

//Связано с оплатой
define('CODE_DEC_FOR_UP', 3);  //код операции списания за поднятие
define('CODE_INC_FOR_UP', 2);  //код операции покупки возможности поднятий
define('CODE_GIFT_MONTH', 1);  //код операции ежемесячный подарок от сайта
//Связано с оплатой через яндекс
define('YAM', '****');
define('YAKEY', '****');
define('PROXY_YAM_CHECK_URL', '****/phpcheck.php');//На этот url отправляем запрос с одним параметром, этот сервер отправляыет нам его же отдельным запросом. После того как отправка нашего запроса завершена, лезем в лог, который оставляет скрипт-приёмник ответного запроса с сервера и сравнивает отправленное и полученное значение
#http://test.gazel.me/pcf

//Связано с оплатой через робокассу
define('RK_P1', '****');
define('RK_P1T', '');
define('RK_P2', '');
define('RK_P2T', '');
define('RK_ID', 'gazelme');
define('RK_TEST_MODE', 1);


//если хочешь отключить оплату в принципе - закомментируй! (будет каждый месяц раздавать всем по 100 бесплатных поднятий)
define('PAY_ENABLED', true);
//если хочешь отключить оплату для физ.лиц - закомментируй!
//define('PAY_PHIS_ENABLED', true);

//если не надо проверять прокси для яндекса, должна быть эта константа
define('CHECK_PROXY_OFF', 1);


//Пароль для запросов из us с сайта объявлений
define('ADV_GATE_PWD', '****');
//mysql_close();
