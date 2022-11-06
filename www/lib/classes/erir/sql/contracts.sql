CREATE TABLE main_user
(
	id INTEGER PRIMARY KEY NOT NULL AUTO_INCREMENT,
	main_id INTEGER,
	user_id INTEGER,
	INDEX main_id (main_id),
	INDEX user_id (user_id)
);
