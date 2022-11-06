UPDATE users SET ordya_last_request = '', ordya_request_id = '', ordya_contract_id = '' ;
UPDATE main SET ordya_last_request = '', ordya_request_id = '', ordya_erid = '' ;
TRUNCATE TABLE main_users;
