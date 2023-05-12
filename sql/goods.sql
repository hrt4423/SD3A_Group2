CREATE TABLE goods(
  user_id INT NOT NULL,
  post_id INT NOT NULL,
  PRIMARY KEY(user_id,post_id),
  FOREIGN KEY(user_id) REFERENCES users(user_id),
  FOREIGN KEY(post_id) REFERENCES posts(post_id)
);

INSERT INTO goods(user_id,post_id) VALUE
(1,3),
(1,6),
(1,9);
