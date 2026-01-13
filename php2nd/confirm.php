<?php
//データを受けてる
$name = $_POST["name"];
$email = $_POST["email"];
$reemail = $_POST["reemail"];
$gender = $_POST["gender"];
$comment = $_POST["comment"];

$error = '';  //エラーメッセージを格納する変数を初期化

//入力チェック
////////////////////////////////////////////////////////////

//名前のチェック（必須）
if(strlen($name) < 1){
  $error = '名前が入力されていません';
}

//メールアドレスのチェック（必須）
if(strlen($email) < 1){
  $error = 'メールアドレスが入力されていません';
}

//メールアドレスの確認
if($email !== $reemail){
  $error = 'メールアドレスが一致していません';
}

//性別のチェック
$gender = intval($gender); //カッコ内の値を強制的に数字に変換（変換できない場合は0）
if($gender == 0){
  $error = '性別が正しく選択されていません';
}

//形式チェック
////////////////////////////////////////////////////////////

//メールアドレスの形式チェック
if(!filter_var($email, FILTER_VALIDATE_EMAIL, FILTER_FLAG_EMAIL_UNICODE)){
  $error = 'メールアドレスの形式が正しくありません';
}

//表示用に変換
////////////////////////////////////////////////////////////
if($gender == 1){
  $gender = '女性';
}elseif($gender == 2){
  $gender = '男性';
}else{
  $gender = 'その他';
}

if($error){
  header('Location:index.html'); //index.htmlにリダイレクト
  exit(); //以降の処理は実行しないためexit
}

//htmlspecialcharsを実行する関数
function esc_html($str){
  return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}
?>

<html>
  <head>
    <title>フォームの確認画面</title>
    <style>
      .confirm{
        display: grid;
        grid-template-columns: 130px 1fr;
        gap: 10px;
        align-items: center;
        h2,p{
          font-size: 1rem;
          margin: 0;
        }
      }
    </style>
  </head>
  <body>
    <div class="confirm">
      <h2>お名前</h2>
      <p><?php echo esc_html($name); ?></p>
      <h2>メールアドレス</h2>
      <p><?php echo esc_html($email); ?></p>
      <h2>性別</h2>
      <p><?php echo esc_html($gender); ?></p>
      <h2>コメント</h2>
      <p><?php echo nl2br(esc_html($comment)); ?></p>
    </div>
  </body>
</html>