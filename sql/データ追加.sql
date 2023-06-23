INSERT INTO posts(
  user_id,
  post_category_id,
  post_time,
  post_title,
  post_detail,
  destination_post_id,
  destination_user_id
) VALUE (
  1,
  1,
  "2024-1-7 11:50:00",
  "テスト質問3",
  "これはテスト質問3です。(post_id: 7, user_id: 1)",
  null,
  null
),(
  2,
  2,
  "2024-1-8 11:50:00",
  "テスト記事3",
  "これはテスト記事3です。(post_id: 8, user_id: 2)",
  null,
  null
),(
  3,
  3,
  "2024-1-9 11:50:00",
  "テストコメント3",
  "これは記事2に宛てたコメントです。(post_id: 9, user_id: 3)",
  2,
  2
),(
  4,
  3,
  "2024-1-10 11:50:00",
  "テストコメント4",
  "これは質問2に宛てたコメントです。(post_id: 10, user_id: 4)",
  4,
  4
),(
  5,
  3,
  "2024-1-11 11:50:00",
  "テストコメント5",
  "これはコメント1に宛てたコメントです。(post_id: 11, user_id: 5)",
  5,
  2
);

INSERT INTO goods(user_id, post_id) VALUE
(1, 5),
(1, 2),
(2, 3),
(2, 4),
(3, 4),
(3, 5),
(4, 4),
(4, 5),
(5, 1),
(5, 2),
(6, 3),
(6, 4);

INSERT INTO attached_tags(post_id, tag_id) VALUE
(1,2),
(1,3),
(2,1),
(3,2),
(4,1);