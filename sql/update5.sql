START TRANSACTION;

-- ボタンカラー属性の追加
ALTER TABLE theme_colors ADD COLUMN button_color_code VARCHAR(128);
-- カラーコードの追加
UPDATE theme_colors SET button_color_code = '#653A91' WHERE theme_color_id = 1;
UPDATE theme_colors SET button_color_code = '#2591FF' WHERE theme_color_id = 2;
UPDATE theme_colors SET button_color_code = '#00C261' WHERE theme_color_id = 3;
UPDATE theme_colors SET button_color_code = '#EFEF00' WHERE theme_color_id = 4;
UPDATE theme_colors SET button_color_code = '#FF8E1F' WHERE theme_color_id = 5;
UPDATE theme_colors SET button_color_code = '#EA4C4C' WHERE theme_color_id = 6;
UPDATE theme_colors SET button_color_code = '#DB2680' WHERE theme_color_id = 7;
UPDATE theme_colors SET button_color_code = '#949494' WHERE theme_color_id = 8;
UPDATE theme_colors SET button_color_code = '#666666' WHERE theme_color_id = 9;

COMMIT;
