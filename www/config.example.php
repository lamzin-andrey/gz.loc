<?php
#================ db====================================================
mysql_pconnect("localhost", "123860", "***") or die('connect error');
mysql_select_db("7****") or die('error select db gz');
mysql_query("SET NAMES UTF8");
#================ constant==============================================
define("DR", $_SERVER["DOCUMENT_ROOT"]);
define("TPLS", DR . '/tpl');
define("MAX_WIDTH", 240);
define("MAX_HEIGHT", 240);
define("ADMIN_PHONE", '+***');
define("SITE_EMAIL", 'admin@gazel.me');
define("SITE_NAME", 'gazel.me');
define('HTTP', 'http://');
define('NOTICE_EMAIL', 'n@gmail.com');
define("H1_BEG", "Заказ ГАЗели в ");
define('AUTO_MODERATION_ON', true);
define('MONTH_IN_SEC', 30*24*3600);

define('SMS_INTERVAL', 63);//product 900
define('SMS_SERVICE_ON', true);
//epochta
define('SMS_SERVICE_LOGIN', '@mail.ru');
define('SMS_SERVICE_PASSWORD', '****');

//
define('SMS_PILOT_API_KEY', '***');

define('EGATE_PWD', '****');

define('ASSETS_VERSION', 'b');

//Связано с оплатой
define('CODE_DEC_FOR_UP', 3);  //код операции списания за поднятие
define('CODE_INC_FOR_UP', 2);  //код операции покупки возможности поднятий
define('CODE_GIFT_MONTH', 1);  //код операции ежемесячный подарок от сайта
//Связано с оплатой через яндекс
define('YAM', '****');
define('YAKEY', '****');
define('PROXY_YAM_CHECK_URL', 'https://****.ru/portfolio/web-razrabotka/saity/fastxampp/js/phpcheck.php');//На этот url отправляем запрос с одним параметром, этот сервер отправляыет нам его же отдельным запросом. После того как отправка нашего запроса завершена, лезем в лог, который оставляет скрипт-приёмник ответного запроса с сервера и сравнивает отправленное и полученное значение
#http://test.gazel.me/pcf

//Связано с оплатой через робокассу
//Связано с оплатой через робокассу
define('RK_P1', '***');//test ***
define('RK_P1T', '****');//test 
define('RK_P2', '****');//test ***
define('RK_P2T', '****');//test 
define('RK_ID', 'gazelme');
//define('RK_TEST_MODE', 1);
//если хочешь отключить оплату в принципе - закомментируй! (будет каждый месяц раздавать всем по 100 бесплатных поднятий)
//define('PAY_ENABLED', true);
//если хочешь отключить оплату для физ.лиц - закомментируй!
define('PAY_PHIS_ENABLED', true);

//если хочешь отключить captcha на форме поднятия объявления - закомментируй
define('CAPTCHA_UPFORM_OFF', true);

//если хочешь отключить captcha на форме подачи объявления авторизованным - закоментируй
define('CAPTCHA_ADV_AUTH_OFF', true);

//если хочешь отключить captcha на форме подачи объявления неавторизованным и авторизованым - закоментируй
define('CAPTCHA_ADV_AL_OFF', true);

define('ADV_GATE_PWD', '*****');

define('POLITICS_DOC', '/images/Politika_zashity_i_obrabotki_personalnyh_dannyh_2019-08-14.doc');

define('ORD_YA_AUTH_TOKEN','********');


// STATIC ERIDS
define('ERID_SRAVNI_RU_INNER','wait-api-yo-ERID_SRAVNI_RU_INNER');		
define('ERID_SRAVNI_RU_INNER_ADV_ID', 2432);						
define('ERID_SRAVNI_RU','wait-api-yo');								
define('ERID_SRAVNI_RU_ADV_ID', 2782);								
define('ERID_GT','wait-api-yo');									
define('ERID_GT_ADV_ID', 2783);										
define('ERID_LIVE_INTERNET', 'wait-api-yo');
define('ERID_LIVE_INTERNET_ADV_ID', 2785);
define('ERID_MAIN_INNER', 'wait-api-yo');							
define('ERID_MAIN_INNER_ADV_ID', 2784);

//mysql_close();
