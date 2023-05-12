CREATE TABLE tags(
  tag_id    INT AUTO_INCREMENT,
  tag_name  VARCHAR(128) NOT NULL,
  PRIMARY KEY (tag_id)
);

INSERT INTO tags(tag_id,tag_name) VALUE
(1,"HTML"),
(2,"css"),
(3,"Javascript"),
(4,"Vue"),
(5,"MySQL"),
(6,"PHP");
