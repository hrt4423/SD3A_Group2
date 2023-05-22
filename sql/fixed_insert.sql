START TRANSACTION;
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
(1,1),
(1,4),
(1,6);

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
(4,4),
(5,5),
(6,6),
(7,1),
(8,2),
(9,3);

INSERT INTO classrooms(classroom_name, is_vacant, updated_time) VALUE
("121",1,"2023-5-11 12:30:00"),
("122",1,"2023-5-11 12:30:00"),
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
(4, "default_image4.png"),
(5, "default_image5.png"),
(6, "default_image6.png");

INSERT INTO post_category(category_name) VALUE
("質問"),
("記事"),
("コメント");
COMMIT;