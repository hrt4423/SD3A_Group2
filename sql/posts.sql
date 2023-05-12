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
