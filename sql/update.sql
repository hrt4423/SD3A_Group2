START TRANSACTION;

ALTER TABLE thema_colors
ADD sub_color_code VARCHAR(128) NOT NULL,
ADD rogo_img VARCHAR(128) NOT NULL;

ALTER TABLE thema_colors
ADD sub_color_code VARCHAR(128) NOT NULL,
ADD rogo_img VARCHAR(128) NOT NULL;

UPDATE `thema_colors` SET `sub_color_code` = '#FAEEFF'
WHERE `thema_colors`.`thema_color_id` = 1;

UPDATE `thema_colors` SET `sub_color_code` = '#ECF4FF'
WHERE `thema_colors`.`thema_color_id` = 2;

UPDATE `thema_colors` SET `sub_color_code` = '#E7FFE9'
WHERE `thema_colors`.`thema_color_id` = 3;

UPDATE `thema_colors` SET `sub_color_code` = '#FEFFDF'
WHERE `thema_colors`.`thema_color_id` = 4;

UPDATE `thema_colors` SET `sub_color_code` = '#FFF8E4'
WHERE `thema_colors`.`thema_color_id` = 5;

UPDATE `thema_colors` SET `sub_color_code` = '#FFEEEE'
WHERE `thema_colors`.`thema_color_id` = 6;

UPDATE `thema_colors` SET `sub_color_code` = '#FFEAEA'
WHERE `thema_colors`.`thema_color_id` = 7;

UPDATE `thema_colors` SET `sub_color_code` = '#ECECEC'
WHERE `thema_colors`.`thema_color_id` = 8;

UPDATE `thema_colors` SET `sub_color_code` = '#CECECE'
WHERE `thema_colors`.`thema_color_id` = 9;




INSERT INTO thema_colors(sub_color_code) VALUE
(''),
(''),
(''),
(''),
(''),
(''),
(''),
('#'),
('');

COMMIT;