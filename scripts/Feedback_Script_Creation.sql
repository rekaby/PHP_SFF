CREATE DATABASE feedbackDB;

connect feedbackDB localhost -u -p;

--Type in sentences are auto or sample
CREATE TABLE Sentences (
sentence_id INT(6) UNSIGNED PRIMARY KEY,
sentence VARCHAR(300) NOT NULL,
sentence_type VARCHAR(8) NOT NULL,
sentence_count INT default 0);


--Type in tryples are auto or new
CREATE TABLE triples (
triple_ID INT(8) UNSIGNED AUTO_INCREMENT  PRIMARY KEY,
sentence_id INT(6) UNSIGNED NOT NULL,
predicate_id INT(6) UNSIGNED NOT NULL,
relation VARCHAR(15) NOT NULL,
arg_start_id INT(6) UNSIGNED NOT NULL,
arg_end_id INT(6) UNSIGNED NOT NULL,
triple_type VARCHAR(8) NOT NULL,
triple_correct INT default 0,
triple_incorrect INT default 0,
triple_no_input INT default 0
);

CREATE TABLE triples_feedback(
triple_id INT UNSIGNED NOT NULL,
feedback INT NOT NULL,
user_name VARCHAR(50) ,
time_stamp timestamp  NOT NULL
);

CREATE TABLE Words(
word_ID INT UNSIGNED NOT NULL,
sentence_id INT(6) UNSIGNED NOT NULL,
word VARCHAR(30) NOT NULL,
pos VARCHAR(10) NOT NULL,
PRIMARY KEY(sentence_id,word_ID)
);

CREATE TABLE Help_Sentences (
help_id INT(6) UNSIGNED AUTO_INCREMENT  PRIMARY KEY,
triple_id INT(6) UNSIGNED NOT NULL,
group_name VARCHAR(50) NOT NULL,
order_index INT(6) UNSIGNED  NOT NULL,
help_comment VARCHAR(1200)-- average 200 words
);

CREATE TABLE Help_Description (
help_id INT(6) UNSIGNED AUTO_INCREMENT  PRIMARY KEY,
group_name VARCHAR(50) NOT NULL,
order_index INT(6) UNSIGNED  NOT NULL default 1,
description VARCHAR(1200)-- average 200 words
);

CREATE USER 'rekaby'@'localhost' IDENTIFIED BY 'p@ssw0rd';
GRANT ALL PRIVILEGES ON *.* TO 'rekaby'@'localhost'  WITH GRANT OPTION;
CREATE USER 'rekaby'@'%' IDENTIFIED BY 'p@ssw0rd';
GRANT ALL PRIVILEGES ON *.* TO 'rekaby'@'%'  WITH GRANT OPTION;

SHOW GRANTS FOR 'rekaby'@'localhost';

SHOW TABLES;
