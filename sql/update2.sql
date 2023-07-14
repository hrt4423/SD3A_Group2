START TRANSACTION;

ALTER TABLE `theme_colors` CHANGE `thema_color_id` `theme_color_id` 
INT(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `theme_colors` CHANGE `thema_color_name` `theme_color_name` 
VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

ALTER TABLE `theme_colors` CHANGE `thema_color_code` `theme_color_code` 
VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

ALTER TABLE `theme_colors` CHANGE `rogo_img` `rogo_path` VARCHAR(128) 
CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

COMMIT;