<?php
session_start();
require('dbconnect.php');
$_SESSION['login_member_id'] = $_REQUEST['member_id'];

$sql = 'SELECT * FROM `members` WHERE `member_id`=?';
$data = array($_SESSION['member_id']);
$stmt = $dbh->prepare($sql);
$stmt->execute($data);
$login_user = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title></title>
  <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.css">
  <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
  <link href="assets/css/bootstrap.css" rel="stylesheet">
  <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="assets/css/timeline.css">
  <link rel="stylesheet" type="text/css" href="assets/css/user.css">
</head>
<body>

<!--プロフィール写真/ 一言-->
  <img align="left" class="fb-image-lg" src="assets/images/<?php echo $login_user['back_picture_path']; ?>" alt="Profile image example"/>
  <img align="left" class="fb-image-profile thumbnail" src="assets/images/<?php echo $login_user['user_picture_path']; ?>" alt="Profile imexample"/>
  <h1><?php echo $login_user['nick_name']; ?></h1>
  <p><?php echo $login_user['self_intro']; ?></p>
       
</body>
</html>