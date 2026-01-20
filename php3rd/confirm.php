<?php
session_start(); //セッションを使えるようにする

//データを受け取る
$name = $_POST["name"];
$email = $_POST["email"];
$reemail = $_POST["reemail"];
$gender = $_POST["gender"];
$comment = $_POST["comment"];

//セッションにユーザーが送信してきたデータを保存する
$_SESSION['name'] = $name;
$_SESSION['email'] = $email;
$_SESSION['reemail'] = $reemail;
$_SESSION['gender'] = $gender;
$_SESSION['comment'] = $comment;

$error = []; //$errorを中身を空として作成しておく

//名前のチェック（必須）
if(strlen($name) < 1){
  //strlen()→括弧内に指定した変数に格納されている文字数を返す
  $error[] = '名前が入力されていません';
}

//メールアドレスのチェック（必須）
if(strlen($email) < 1){
  $error[] = 'メールアドレスが入力されていません';
}

//メールアドレス確認のチェック
if($email !== $reemail){
  //メールアドレスが一致していない
  $error[] = 'メールアドレスが一致しません';
}

//性別のチェック
$gender = intval($gender);//intval()→括弧内の値を強制的に数字に変換する。変換できないときは0になる
if($gender == 0){
  $error[] = '性別が正しく選択されていません';
}

//メールアドレスの形式チェック
//メールアドレスの形式として妥当であれば、trueという値が返る
if(!filter_var($email,FILTER_VALIDATE_EMAIL,FILTER_FLAG_EMAIL_UNICODE)){
  //先頭に!を入れることで、結果を逆転させる（true→falseになり、falseだったらtrueになる）→メールアドレスが間違えているとtrueになる
  $error[] = 'メールアドレスの形式が正しくありません';
}

if(count($error) > 0){//$errorの中身が空ではない
  $_SESSION['error'] = $error;
  header('Location:index.php');//index.htmlに飛ばす
  exit();//プログラムを終了させる
}

//htmlspecailchars()の関数を作成
function eschtml($string){
  return htmlspecialchars($string,ENT_QUOTES);
}

if($gender == 1){
  $gender = '女性';
}
elseif($gender == 2){
  $gender = '男性';
}
else{
  $gender = 'その他';
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>お問い合わせフォーム</title>
  <link href="style.css" rel="stylesheet">
</head>
<body>
  <main>
    <form name="form1" method="POST" action="complete.php">
      <p><label>名前<small>必須</small>
        <?php echo eschtml($name); ?>
      </label></p>
      <p><label>メールアドレス<small>必須</small>
        <?php echo eschtml($email); ?>
      </label></p>
      <p>性別
        <?php echo $gender; ?>
      </p>
      <p><label>コメント</label>
        <?php echo nl2br(eschtml($comment)); ?>
      </p>
      <p><input type="submit" value="お問い合わせする"><button type="button" onclick="history.go(-1);">戻って編集</button>
      </p>
    </form>
  </main>
</body>
</html>