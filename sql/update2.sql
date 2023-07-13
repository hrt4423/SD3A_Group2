START TRANSACTION;

ALTER TABLE thema_colors RENAME COLUMN thema_color_id TO theme_color_id;

ALTER TABLE theme_colors RENAME COLUMN thema_color_name TO theme_color_name;

ALTER TABLE theme_colors RENAME COLUMN thema_color_code TO theme_color_code;

COMMIT;