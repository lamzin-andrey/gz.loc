CREATE TABLE ordya_invoices(
 id INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL COMMENT 'POST invoice number Таблица хранит номера актов, чтобы они каждый месяц инкрементились',
 main_id INTEGER COMMENT 'Ссылка на креатив, который в нашем случае === объявление.',
 INDEX main_id (main_id),
 start_date DATETIME COMMENT 'Дата начала периода. Равна началу месяца, за который отправляется отчет. Но если дата создания объявления больше, равна дате создания',
 end_date DATETIME COMMENT 'именно по нему будем искать запись. Если нет, создаем новую',
 INDEX end_date (end_date)
);

CREATE TABLE ordya_erid_invoices_stat(
 id INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL COMMENT 'POST invoice imps, amount. Таблица хранит количество показов каждого объявления за месяц',
 invoice_id INTEGER COMMENT 'ссылка на ordya_invoices',
 INDEX invoice_id (invoice_id),
 imps INTEGER COMMENT 'кол-во показов',
 amounts DECIMAL(10, 2) COMMENT 'стоимость оказанных услуг, пригодится, когда включу оплату.  amountPerShow  буду получить деля amounts на imps',
 ordya_request_id VARCHAR(255) COMMENT 'Нужен, чтобы запрашивать GET status.',
 is_sended TINYINT COMMENT '1 когда отправлено успешно.',
 ordya_status VARCHAR(255) COMMENT 'будем записывать ответы',
 ordya_last_request DATETIME COMMENT 'Время последнего запроса на сервер ОРДЯ'
);
