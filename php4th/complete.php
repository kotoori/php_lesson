<?php
session_start(); //セッションを使えるようにする

if(empty($_SESSION)){
  // URLを直叩きしてきた場合は、index.phpに飛ばす
  header('Location:index.php');
  exit;
}

require 'define.inc.php';
$dsn = 'mysql:dbname='.DBNAME.';host='.DBHOST.';port='.DBPORT;
try{
  $dbh = new PDO($dsn,DBUSER,DBPASS); //接続を試みる
}
catch(PDOException $e){
  //DBへの接続で問題が出た場合はここにくる
  echo 'DBへ接続できません'.$e->getMessage();
  exit;
}

// セッションからデータを取り出して変数に格納する
$name = $_SESSION['name'];
$email = $_SESSION['email'];
$gender = $_SESSION['gender'];
$comment = $_SESSION['comment'];

//DBにデータを格納する
$regdate = date('Y-m-d H:i:s');

$sql = "INSERT INTO contactdata VALUES(NULL, ?, ?, ?, ?, '$regdate')";

$stmt = $dbh->prepare($sql);
$result = $stmt->execute(array($name,$email,$gender,$comment));
if($result){
  echo 'DBに登録できました';
}
$sql = "SELECT * FROM contactdata";
$stmt = $dbh->prepare($sql);
$result = $stmt->execute();
while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
  echo $row['name'].'<br>';
  echo $row['email'].'<br>';
  echo $row['gender'].'<br>';
  echo $row['comment'].'<br>';
  echo $row['regdate'].'<br>';
}
?>

<!DOCTYPE html>
<html lang="ja" prefix="og: https://ogp.me/ns#">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="format-detection" content="telephone=no">

  <!-- noindex,nofollow -->
  <meta name="robots" content="noindex,nofollow">

  <!-- ページ属性情報 -->
  <title>お問い合わせフォーム</title>
  <meta name="description" content="詳細説明詳細説明詳細説明">
</head>
<body>
  <h1>お問い合わせ完了</h1>
</body>
</html>
