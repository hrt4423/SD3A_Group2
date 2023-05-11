CREATE TABLE emptyClassrooms(
  classroom_id    INT NOT NULL,
  classroom_name VARCHAR(128) NOT NULL,
  availability   TINYINT NOT NULL,
  updated_time   DATETIME NOT NULL,
  PRIMARY KEY (classroom_id)
);

INSERT INTO emptyClassrooms(classroom_id,classroom_name,availability,updated_time) VALUE
(1,"121",1,"2023-5-11 12:30:00")
(2,"122",1,"2023-5-11 12:30:00")
(3,"123",0,"2023-5-11 12:30:00")
(4,"124",1,"2023-5-11 12:30:00")
(5,"125",0,"2023-5-11 12:30:00")
(6,"126",1,"2023-5-11 12:30:00")
(7,"131",0,"2023-5-11 12:30:00")
(8,"132",1,"2023-5-11 12:30:00")
(9,"133",1,"2023-5-11 12:30:00")
(10,"134",0,"2023-5-11 12:30:00")
(11,"135",0,"2023-5-11 12:30:00")
(12,"136",1,"2023-5-11 12:30:00")
(13,"141",1,"2023-5-11 12:30:00")
(14,"142",1,"2023-5-11 12:30:00");
