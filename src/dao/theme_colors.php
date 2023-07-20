<?php
  class themeColors{
    private $pdo;
    public function __construct() {
      require_once('connection.php');
      $connection = new Connection();
      $this->pdo = $connection->getPdo();
    }

    //カラーコード取得
    public function getThemeColorCode($themeColorId){
      $sql = "SELECT theme_color_code FROM theme_colors WHERE theme_color_id = ?";
      $ps = $this->pdo->prepare($sql);
      $ps->bindValue(1, $themeColorId, PDO::PARAM_INT);
      $ps->execute();
      $result = $ps->fetchAll(PDO::FETCH_ASSOC);

      if(isset($result[0]['theme_color_code'])) {
        return $result[0]['theme_color_code'];
      }else{
        throw new Exception('theme_color_codeが取得できませんでした。');
      }
    }

    public function getSubColorCode($themeColorId){
      $sql = "SELECT sub_color_code FROM theme_colors WHERE theme_color_id = ?";
      $ps = $this->pdo->prepare($sql);
      $ps->bindValue(1, $themeColorId, PDO::PARAM_INT);
      $ps->execute();
      $result = $ps->fetchAll(PDO::FETCH_ASSOC);

      if(isset($result[0]['sub_color_code'])) {
        return $result[0]['sub_color_code'];
      }else{
        throw new Exception('sub_color_codeが取得できませんでした。');
      }
    }

    public function getLogoPath($themeColorId) {
      $sql = "SELECT logo_path FROM theme_colors WHERE theme_color_id = ?";
      $ps = $this->pdo->prepare($sql);
      $ps->bindValue(1, $themeColorId, PDO::PARAM_INT);
      $ps->execute();
      $result = $ps->fetchAll(PDO::FETCH_ASSOC);

      if(isset($result[0]['logo_path'])) {
        return $result[0]['logo_path'];
      }else{
        throw new Exception('logo_pathが取得できませんでした。');
      }

    }

    //ボタンカラーの取得

  }
?>