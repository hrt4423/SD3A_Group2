START TRANSACTION;

CREATE TABLE thema_colors(
  thema_color_id    INT AUTO_INCREMENT,
  thema_color_name  VARCHAR(128) NOT NULL,
  thema_color_code  VARCHAR(128) NOT NULL,
  PRIMARY KEY (thema_color_id)
);

CREATE TABLE post_categories(
  post_category_id    INT AUTO_INCREMENT,
  category_name  VARCHAR(4) NOT NULL,
  PRIMARY KEY (post_category_id)
);

CREATE TABLE users(
  user_id       INT AUTO_INCREMENT,
  user_name     VARCHAR(128) NOT NULL,
  user_icon     VARCHAR(128) DEFAULT 'imagePath',
  user_mail     VARCHAR(128) NOT NULL UNIQUE,
  user_pass     VARCHAR(256) NOT NULL,
  user_point    INT NOT NULL DEFAULT 0,
  point_sum     INT NOT NULL DEFAULT 0,
  user_level    INT NOT NULL DEFAULT 0,
  user_profile  VARCHAR(300) NOT NULL,
  thema_color_id     INT NOT NULL DEFAULT 1,
  PRIMARY KEY (user_id),
  FOREIGN KEY(thema_color_id) REFERENCES thema_colors(thema_color_id)
);

CREATE TABLE posts(
  post_id       INT AUTO_INCREMENT,
  user_id     INT NOT NULL,
  post_category_id     INT NOT NULL,
  post_time     DATETIME NOT NULL,
  post_title     VARCHAR(128) NOT NULL,
  post_detail    VARCHAR(10000) NOT NULL,
  post_priority    INT NOT NULL DEFAULT 24,
  destination_post_id  INT,
  destination_user_id   INT,
  PRIMARY KEY (post_id),
  FOREIGN KEY (user_id) REFERENCES users(user_id),
  FOREIGN KEY (post_category_id) REFERENCES post_categories
(post_category_id),
  FOREIGN KEY (destination_post_id) REFERENCES posts(post_id),
  FOREIGN KEY (destination_user_id) REFERENCES users(user_id)
);

CREATE TABLE images(
  image_id    INT AUTO_INCREMENT,
  post_id     INT NOT NULL,
  image_path  VARCHAR(128) NOT NULL,
  PRIMARY KEY (image_id),
  FOREIGN KEY (post_id) REFERENCES posts(post_id)
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

CREATE TABLE attached_tags(
  post_id INT NOT NULL,
  tag_id INT NOT NULL,
  PRIMARY KEY(post_id,tag_id),
  FOREIGN KEY(post_id) REFERENCES posts(post_id),
  FOREIGN KEY(tag_id) REFERENCES tags(tag_id)
);

CREATE TABLE classrooms(
  classroom_id    INT AUTO_INCREMENT,
  classroom_name VARCHAR(10) NOT NULL,
  is_vacant   TINYINT NOT NULL,
  updated_time   DATETIME NOT NULL,
  PRIMARY KEY (classroom_id)
);


INSERT INTO thema_colors(thema_color_name, thema_color_code)
VALUE
("purple", "#B164FF"),
("bule", "#64B1FF"),
("green", "#64FFB1"),
("yellow", "#FFFF64"),
("orange", "#FFB164"),
("red", "#FF6464"),
("pink", "#FF64B1"),
("white", "#FFFFFF"),
("black", "#000000");

INSERT INTO users(
  user_name,
  user_icon,
  user_mail,
  user_pass,
  user_profile
) VALUE (
  "平田",
  "default_icon.png",
  "hirata@gmail.com",
  "password",
  "helllo"
),(
  "馬場",
  "default_icon.png",
  "baba@gmail.com",
  "password",
  "helllo"
),(
  "立石",
  "default_icon.png",
  "tateishi@gmail.com",
  "password",
  "helllo"
),(
  "野村",
  "dafault_icon.png",
  "nomura@gmail.com",
  "password",
  "helllo"
),(
  "別納",
  "default_icon.png",
  "betuno@gmail.com",
  "password",
  "helllo"
),(
  "糸山",
  "default_icon.png",
  "itoyama@gmail.com",
  "password",
  "helllo"
);

INSERT INTO post_categories(category_name) VALUE
("質問"),
("記事"),
("コメント");

INSERT INTO posts(
  user_id,
  post_category_id,
  post_time,
  post_title,
  post_detail
) VALUE (
  1,
  2,
  "2024-1-1 11:50:00",
  "テスト記事1",
  "これはテスト記事１です。(post_id: 1, user_id: 1)"
),(
  2,
  2,
  "2024-1-2 11:50:00",
  "テスト記事2",
  "これはテスト記事２です。(post_id: 2, user_id: 2)"
),(
  3,
  1,
  "2024-1-3 11:50:00",
  "テスト質問１",
  "これはテスト質問１です。(post_id: 3, user_id: 3)"
),(
  4,
  1,
  "2024-1-4 11:50:00",
  "テスト質問２",
  "これはテスト質問２です。(post_id:4, user_id: 4)"
);

INSERT INTO goods(user_id, post_id) VALUE
(1,1),
(1,4);

INSERT INTO tags(tag_name) VALUE
("HTML"),
("css"),
("Javascript"),
("Vue.js"),
("MySQL"),
("PHP");

INSERT INTO attached_tags(post_id, tag_id) VALUE
(1,1),
(2,2),
(3,3),
(4,4);

INSERT INTO classrooms(classroom_name, is_vacant, updated_time) VALUE
("121", 1, "2023-5-11 12:30:00"),
("122", 1,"2023-5-11 12:30:00"),
("123",0,"2023-5-11 12:30:00"),
("124",1,"2023-5-11 12:30:00"),
("125",0,"2023-5-11 12:30:00"),
("126",1,"2023-5-11 12:30:00"),
("131",0,"2023-5-11 12:30:00"),
("132",1,"2023-5-11 12:30:00"),
("133",1,"2023-5-11 12:30:00"),
("134",0,"2023-5-11 12:30:00"),
("135",0,"2023-5-11 12:30:00"),
("136",1,"2023-5-11 12:30:00"),
("141",1,"2023-5-11 12:30:00"),
("142",1,"2023-5-11 12:30:00");

INSERT INTO images(post_id, image_path) VALUE
(1, "default_image1.png"),
(2, "default_image2.png"),
(3, "default_image3.png"),
(4, "default_image4.png");

INSERT INTO posts(
  user_id,
  post_category_id,
  post_time,
  post_title,
  post_detail,
  destination_post_id,
  destination_user_id
) VALUE (
  2,
  3,
  "2024-1-5 11:50:00",
  "テストコメント１",
  "これは記事１に宛てたコメントです。",
  1,
  1
),(
  1,
  3,
  "2024-1-6 11:50:00",
  "テストコメント2",
  "これは質問１に宛てたコメントです。",
  3,
  3
);

INSERT INTO goods(user_id, post_id) VALUE
(2, 6),
(3, 6),
(4, 6);

INSERT INTO images(post_id, image_path) VALUE
(5, "dafault_image5.png"),
(6, "dafault_image6.png");

ALTER TABLE thema_colors
ADD sub_color_code VARCHAR(128) NOT NULL,
ADD rogo_img VARCHAR(128) NOT NULL;

INSERT INTO thema_colors(sub_color_code) VALUE
('#F9EDFF'),
('#ECF4FF'),
('#E7FFE9'),
('#FEFFDF'),
('#FFF8E4'),
('#FFEEEE'),
('#FFEAEA'),
('#FFFFFF'),
('#CECECE');

COMMIT;