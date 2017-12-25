-- The contents of this file should be uploaded to a mysql shell

-- CREATE DATABASE testing_url4cash;

-- USE testing_url4cash;

CREATE TABLE url_users
(
	id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
	user_name VARCHAR(255) NOT NULL,
	first_name VARCHAR(255),
	last_name VARCHAR(255),
	user_email VARCHAR(255),
	user_paypal VARCHAR(255),
	user_password VARCHAR(255),
	country VARCHAR(255) NOT NULL,
	currency DECIMAL(2,2),
	clicks INT DEFAULT 0,
	INDEX(id)	
);

CREATE TABLE url_urls
(
	url_id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
	user_id INT NOT NULL,
	web_url TEXT,
	web_nurl VARCHAR(255),
	INDEX(web_nurl)
);
-- This insert statement is NECESSARY
INSERT INTO url_urls(user_id,web_url,web_nurl) VALUES('0','TEST','0');

CREATE TABLE url_click
(
    dtime DATETIME NOT NULL,
    ip_addr VARCHAR(255) NOT NULL,
    user_id INT NOT NULL,
    url_id INT NOT NULL,
    ad_id INT NOT NULL,
    url_link TEXT,
    INDEX(dtime)
);

CREATE TABLE ad_entry
(
    ad_id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    ad_txt TEXT,
    ad_name VARCHAR(255),
    ad_link VARCHAR(255),
    ad_type INT(2),
    -- 0 is banner, 1 interstatial
    INDEX(ad_id)
);

ALTER TABLE url_urls ADD web_type VARCHAR(255);
UPDATE url_urls SET web_type = 'banner';
