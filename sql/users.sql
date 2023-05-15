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

INSERT INTO users(user_id,user_name,user_icon,user_mail,user_pass,user_point,user_level,user_profile) VALUE
(1,"平田","icon1","hirata@gmail.com","hirata",100,1,"helllo"),
(2,"馬場","icon2","baba@gmail.com","baba",90,1,"helllo"),
(3,"立石","icon3","tateishi@gmail.com","tateishi",80,1,"helllo"),
(4,"野村","icon4","nomura@gmail.com","nomura",70,1,"helllo"),
(5,"別納","icon5","betuno@gmail.com","betuno",60,1,"helllo"),
(6,"糸山","icon6","itoyama@gmail.com","itoyama",50,1,"helllo");