<?php
session_start();
require('dbconnect.php');

$_SESSION['login_member_id'] = 5;
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title></title>
  <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="assets/css/left_sideber.css">
  <link rel="stylesheet" type="text/css" href="assets/css/main.css">
</head>
<body>
  <div class="container">
    <div class="row content">
      <div class="col-md-3 left-content">
        <?php require('left_sidebar.php'); ?>
      </div>
    </div>
  </div>

</body>
</html>