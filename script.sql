CREATE DATABASE news;

USE news;

CREATE TABLE
    messages (
                 id int UNSIGNED not null primary key auto_increment,
                 title varchar(255) NOT NULL,
                 body text,
                 created_at DATETIME NOT NULL DEFAULT NOW()
);