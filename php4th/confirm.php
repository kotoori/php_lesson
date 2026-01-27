<?php
session_start();//セッションを使えるようにする

//データを受け取る
$name = $_POST["name"];
$email = $_POST["email"];
$reemail = $_POST["reemail"];
$gender = $_POST["gender"];
$comment = $_POST["comment"];

//セッションにユーザーが送信してきたデータを保存する
$_SESSION["name"] = $name;
$_SESSION["email"] = $email;
$_SESSION["reemail"] = $reemail;
$_SESSION["gender"] = $gender;
$_SESSION["comment"] = $comment;

$error = [];//$errorを中身を配列として作成しておく
$filename = '';//$filenameを空として作成しておく

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

//画像ファイルの処理
if(isset($_FILES) && !empty($_FILES)){
  //ファイルが送信されてきているので、処理する
  if($_FILES["image"]["error"] !== UPLOAD_ERR_OK){
    //ファイルのアップロードに失敗している
    $error[] = 'ファイルのアップロードに失敗しました';
  }
  else{
    $type = exif_imagetype($_FILES["image"]["tmp_name"]);
    //画像の形式を取得する。$_FILES["image"]["tmp_name"]→PHPが勝手に付けた一時ファイル名
    if(($type != IMAGETYPE_JPEG) && ($type != IMAGETYPE_PNG)){
      //画像形式としてJPEGとPNGだけ許可しているが、どちらでも無い
      $error[] = '画像形式がJPEG形式でもPNG形式でも無いです';
    }
    else{
      $filename = $_FILES["image"]["name"];//元のファイル名を取得
      $filename = uniqid().$filename;//uniqid()→ランダムな英数字を生成
      move_uploaded_file($_FILES["image"]["tmp_name"],'upload/'.$filename);//一時ファイル名を指定して、そこから指定したファイル名に変更しつつ、ファイルを移動する
    }
  }
}

if(count($error)){//count()→配列の個数を返す。もし、配列内に何らかの中身が入っていれば成立する
  $_SESSION["error"] = $error;
  header('Location:index.php');//index.phpに飛ばす
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
      <?php
        if(file_exists('upload/'.$filename)){
          //file_exists()→括弧内に指定したファイルが存在するかどうかチェック
          echo '<p><img src="upload/'.$filename.'" alt=""></p>';
        }
      ?>
      <p><label>コメント</label>
        <?php echo nl2br(eschtml($comment)); ?>
      </p>
      <p><input type="submit" value="お問い合わせする"><button type="button" onclick="history.go(-1);">戻って編集</button>
      </p>
    </form>
  </main>
</body>
</html>