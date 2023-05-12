<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>connectTest</title>
</head>
<body>
  <?php
    require_once('dao.php');
    $dao = new DAO_test();
    echo  $dao -> getUserName(1);
  ?>
</body>
</html>