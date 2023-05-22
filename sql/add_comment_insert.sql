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
