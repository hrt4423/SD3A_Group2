START TRANSACTION;

ALTER TABLE posts ADD COLUMN parent_post_id INT;

ALTER TABLE thema_colors
ADD sub_color_code VARCHAR(128) NOT NULL,
ADD rogo_img VARCHAR(128) NOT NULL;

UPDATE `thema_colors` SET `sub_color_code` = '#FAEEFF',
'rogo_img' = 'logo.png'
WHERE `thema_colors`.`thema_color_id` = 1;

UPDATE `thema_colors` SET `sub_color_code` = '#ECF4FF',
'rogo_img' = 'logo_blue.png'
WHERE `thema_colors`.`thema_color_id` = 2;

UPDATE `thema_colors` SET `sub_color_code` = '#E7FFE9'
'rogo_img' = 'logo_green.png'
WHERE `thema_colors`.`thema_color_id` = 3;

UPDATE `thema_colors` SET `sub_color_code` = '#FEFFDF'
'rogo_img' = 'logo_yellow.png'
WHERE `thema_colors`.`thema_color_id` = 4;

UPDATE `thema_colors` SET `sub_color_code` = '#FFF8E4'
'rogo_img' = 'logo_orange.png'
WHERE `thema_colors`.`thema_color_id` = 5;

UPDATE `thema_colors` SET `sub_color_code` = '#FFEEEE'
'rogo_img' = 'logo_red.png'
WHERE `thema_colors`.`thema_color_id` = 6;

UPDATE `thema_colors` SET `sub_color_code` = '#FFEAEA'
'rogo_img' = 'logo_pink.png'
WHERE `thema_colors`.`thema_color_id` = 7;

UPDATE `thema_colors` SET `sub_color_code` = '#ECECEC'
'rogo_img' = 'logo_white.png'
WHERE `thema_colors`.`thema_color_id` = 8;

UPDATE `thema_colors` SET `sub_color_code` = '#CECECE'
'rogo_img' = 'logo_black.png'
WHERE `thema_colors`.`thema_color_id` = 9;

ALTER TABLE thema_colors RENAME TO theme_colors;

ALTER TABLE thema_colors RENAME COLUMN thema_color_id TO theme_color_id;

ALTER TABLE theme_colors RENAME COLUMN thema_color_name TO theme_color_name;

ALTER TABLE theme_colors RENAME COLUMN thema_color_code TO theme_color_code;

COMMIT;