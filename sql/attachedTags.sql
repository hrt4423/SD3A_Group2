CREATE TABLE attachedTags(
  post_id INT NOT NULL,
  tag_id INT NOT NULL,
  PRIMARY KEY(post_id,tag_id),
  FOREIGN KEY(post_id) REFERENCES posts(post_id),
  FOREIGN KEY(tag_id) REFERENCES tags(tag_id)
);

INSERT INTO attachedTags(post_id,tag_id) VALUE
(1,1)
(2,2)
(3,3)
(4,4)
(5,5)
(6,6)
(7,1)
(8,2)
(9,3);
