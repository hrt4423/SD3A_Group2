START TRANSACTION;

ALTER TABLE thema_colors RENAME COLUMN thema_color_id, TO theme_color_id,

RENAME COLUMN thema_color_name, TO theme_color_name,

RENAME COLUMN thema_color_code, TO theme_color_code;

COMMIT;