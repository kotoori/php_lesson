<?php
  session_start();
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
    <?php
      //エラーメッセージを表示する
      if(isset($_SESSION["error"]) && count($_SESSION["error"])){
        //エラーが存在している→表示する
        echo '<ul class="error">';
        for($i = 0; $i < count($_SESSION["error"]);$i++){
          echo '<li>'.$_SESSION["error"][$i].'</li>';
        }
        echo '</ul>';
      }
    ?>
    <form name="form1" method="POST" action="confirm.php" enctype="multipart/form-data">
    <dl>
      <dt><label>名前<small>必須</small></label></dt>
      <dd><input type="text" name="name" placeholder="山田太郎" value="<?php if(!empty($_SESSION["name"])){ echo $_SESSION["name"]; } ?>"></dd>
      <dt><label>メールアドレス<small>必須</small></label></dt>
      <dd><input type="email" name="email" required placeholder="mail@example.com" value="<?php if(!empty($_SESSION["email"])){ echo $_SESSION["email"]; } ?>"></dd>
      <dt><label>メールアドレス確認<small>必須</small></label></dt>
      <dd><input type="email" name="reemail" required placeholder="mail@example.com" value="<?php if(!empty($_SESSION["reemail"])){ echo $_SESSION["reemail"]; } ?>"></dd>
      <dt>性別</dt>
      <dd>
        <label>
          <input type="radio" name="gender" value="1" checked>女性
        </label>
        <label>
          <input type="radio" name="gender" value="2">男性
        </label>
        <label>
          <input type="radio" name="gender" value="3">その他
        </label>
      </dd>
      <dt><label>画像ファイル</label></dt>
      <dd><input type="file" name="image"></dd>
      <dt><label>コメント</label></dt>
      <dd><textarea name="comment" placeholder="コメント内容"><?php if(!empty($_SESSION["comment"])){ echo $_SESSION["comment"]; } ?></textarea></dd>
      <p><input type="submit" value="お問い合わせする"></p>
      </dl>
    </form>
  </main>
</body>
</html>