CREATE TABLE users(
  user_id       INT AUTO_INCREMENT,
  user_name     VARCHAR(128) NOT NULL,
  user_icon     VARCHAR(128) DEFAULT 'aaa',
  user_mail     VARCHAR(128) NOT NULL,
  user_pass     VARCHAR(128) NOT NULL,
  user_point    INT NOT NULL DEFAULT 0,
  user_level    INT NOT NULL DEFAULT 0,
  user_profile  VARCHAR(128) NOT NULL,
  usr_color     VARCHAR(128) NOT NULL DEFAULT 'purple',
  PRIMARY KEY (user_id)
);

CREATE TABLE posts(
  post_id       INT AUTO_INCREMENT,
  user_id     INT NOT NULL,
  post_kinds     VARCHAR(128) NOT NULL,
  post_time     DATETIME NOT NULL,
  post_title     VARCHAR(128) NOT NULL,
  post_detail    INT NOT NULL,
  post_priority    INT NOT NULL DEFAULT 1,
  post_send_id  INT NOT NULL,
  PRIMARY KEY (post_id),
  FOREIGN KEY (user_id) REFERENCES users(user_id)
);

CREATE TABLE goods(
  user_id INT NOT NULL,
  post_id INT NOT NULL,
  PRIMARY KEY(user_id,post_id),
  FOREIGN KEY(user_id) REFERENCES users(user_id),
  FOREIGN KEY(post_id) REFERENCES posts(post_id)
);

CREATE TABLE tags(
  tag_id    INT AUTO_INCREMENT,
  tag_name  VARCHAR(128) NOT NULL,
  PRIMARY KEY (tag_id)
);

CREATE TABLE attachedTags(
  post_id INT NOT NULL,
  tag_id INT NOT NULL,
  PRIMARY KEY(post_id,tag_id),
  FOREIGN KEY(post_id) REFERENCES posts(post_id),
  FOREIGN KEY(tag_id) REFERENCES tags(tag_id)
);

CREATE TABLE emptyClassrooms(
  classroom_id    INT NOT NULL,
  classroom_name VARCHAR(128) NOT NULL,
  availability   TINYINT NOT NULL,
  updated_time   DATETIME NOT NULL,
  PRIMARY KEY (classroom_id)
);

START TRANSACTION;

INSERT INTO users(user_id,user_name,user_icon,user_mail,user_pass,user_point,user_level,user_profile) VALUE
(1,"平田","icon1","hirata@gmail.com","hirata",100,1,"helllo"),
(2,"馬場","icon2","baba@gmail.com","baba",90,1,"helllo"),
(3,"立石","icon3","tateishi@gmail.com","tateishi",80,1,"helllo"),
(4,"野村","icon4","nomura@gmail.com","nomura",70,1,"helllo"),
(5,"別納","icon5","betuno@gmail.com","betuno",60,1,"helllo"),
(6,"糸山","icon6","itoyama@gmail.com","itoyama",50,1,"helllo");

INSERT INTO posts(post_id,user_id,post_kinds,post_time,post_title,post_detail) VALUE
(1,1,"記事","2023-5-11 11:50:00","テスト記事1","テスト記事作成1"),
(2,1,"記事","2023-5-11 11:51:00","テスト記事2","テスト記事作成2"),
(3,1,"質問","2023-5-11 11:52:00","テスト質問1","テスト質問作成1"),
(4,1,"質問","2023-5-11 11:53:00","テスト質問2","テスト質問作成2"),
(5,1,"質問","2023-5-11 11:54:00","テスト質問3","テスト質問作成3"),
(6,2,"記事","2023-5-11 11:55:00","テスト記事1","テスト記事作成1"),
(7,2,"記事","2023-5-11 11:56:00","テスト記事2","テスト記事作成2"),
(8,2,"質問","2023-5-11 11:57:00","テスト質問1","テスト質問作成1"),
(9,2,"質問","2023-5-11 11:58:00","テスト質問2","テスト質問作成2");

INSERT INTO goods(user_id,post_id) VALUE
(1,3),
(1,6),
(1,9);

INSERT INTO tags(tag_id,tag_name) VALUE
(1,"HTML"),
(2,"css"),
(3,"Javascript"),
(4,"Vue"),
(5,"MySQL"),
(6,"PHP");

INSERT INTO attachedTags(post_id,tag_id) VALUE
(1,1),
(2,2),
(3,3),
(4,4),
(5,5),
(6,6),
(7,1),
(8,2),
(9,3);

INSERT INTO emptyClassrooms(classroom_id,classroom_name,availability,updated_time) VALUE
(1,"121",1,"2023-5-11 12:30:00"),
(2,"122",1,"2023-5-11 12:30:00"),
(3,"123",0,"2023-5-11 12:30:00"),
(4,"124",1,"2023-5-11 12:30:00"),
(5,"125",0,"2023-5-11 12:30:00"),
(6,"126",1,"2023-5-11 12:30:00"),
(7,"131",0,"2023-5-11 12:30:00"),
(8,"132",1,"2023-5-11 12:30:00"),
(9,"133",1,"2023-5-11 12:30:00"),
(10,"134",0,"2023-5-11 12:30:00"),
(11,"135",0,"2023-5-11 12:30:00"),
(12,"136",1,"2023-5-11 12:30:00"),
(13,"141",1,"2023-5-11 12:30:00"),
(14,"142",1,"2023-5-11 12:30:00");
COMMIT;