-- Create users table for admins, authors, editors:
CREATE TABLE IF NOT EXISTS se_users (ID INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY, user_login VARCHAR(50) NOT NULL DEFAULT '' UNIQUE, user_pass VARCHAR(32) NOT NULL DEFAULT '', user_email VARCHAR(100) NOT NULL DEFAULT '' UNIQUE,  user_authenticate VARCHAR(48) DEFAULT '', user_registered DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, user_failed_status INT(11) NOT NULL DEFAULT 0, user_type VARCHAR(20) NOT NULL DEFAULT '', user_failed_login BIGINT(20) DEFAULT 0, user_read_logs INT(11) DEFAULT 0, user_enter INT(11) NOT NULL);

-- Create pages, posts, table:
CREATE TABLE IF NOT EXISTS se_pages (ID INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY, page_title VARCHAR(255) NOT NULL DEFAULT '', page_content LONGTEXT NOT NULL DEFAULT '', page_template TINYTEXT NOT NULL DEFAULT '',  page_meta TINYTEXT NOT NULL DEFAULT '' , page_url VARCHAR(255) NOT NULL DEFAULT '' UNIQUE, page_added DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, page_visible DATETIME NOT NULL, page_status VARCHAR(50) NOT NULL,  tag_ID LONGTEXT, cat_ID LONGTEXT, page_hit INT(11) NOT NULL, page_like INT(11) NOT NULL, page_dislike INT(11) NOT NULL, author_ID INT(11) NOT NULL DEFAULT 0, editor_ID INT(11) NOT NULL);

-- Create tags table
CREATE TABLE IF NOT EXISTS se_tags (ID INT (11) NOT NULL AUTO_INCREMENT PRIMARY KEY, tag_title VARCHAR(128) NOT NULL DEFAULT '' UNIQUE, tag_description VARCHAR(255) NOT NULL DEFAULT '', tag_slug VARCHAR(50) NOT NULL DEFAULT '' UNIQUE, posts_id LONGTEXT NOT NULL DEFAULT '');

-- Create category table
CREATE TABLE IF NOT EXISTS se_category (ID INT (11) NOT NULL AUTO_INCREMENT PRIMARY KEY, cat_title VARCHAR(128) NOT NULL DEFAULT '' UNIQUE, cat_description VARCHAR(255) NOT NULL DEFAULT '', cat_slug VARCHAR(50) NOT NULL DEFAULT '' UNIQUE, cat_parent INT(11) NOT NULL DEFAULT 0, posts_id LONGTEXT NOT NULL DEFAULT '');

-- Insert into category table
INSERT INTO se_category(cat_title, cat_description, cat_slug) VALUES ('Uncategorized', 'This is the default category for the post', 'uncategorized');

-- Create event table
CREATE TABLE IF NOT EXISTS se_events(ID INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY, page_visible_remove DATETIME NOT NULL, event_id INT(11) NOT NULL);

-- Create meta table
CREATE TABLE IF NOT EXISTS se_meta(ID INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY, primary_admin VARCHAR(100) NOT NULL DEFAULT '', theme_applied VARCHAR(50) NOT NULL DEFAULT '', website_title VARCHAR(100) NOT NULL, website_meta TEXT NOT NULL, website_description MEDIUMTEXT NOT NULL, website_url VARCHAR(255) NOT NULL, page_hit INT(11) NOT NULL, page_like INT(11) NOT NULL, page_dislike INT(11) NOT NULL);

-- Insert into meta table
INSERT INTO se_meta(theme_applied) VALUES ('Hinata');