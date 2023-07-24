<?php
class Classrooms{

private $pdo;
public function __construct() {
  require_once('connection.php');
  $connection = new Connection();
  $this->pdo = $connection->getPdo();
}

public function getclassroom(){
    $sql="SELECT * FROM classrooms";
    $ps = $this->pdo->prepare($sql);
    $ps->execute();
    $result = $ps->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}
}