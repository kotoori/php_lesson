<?php
  session_start();
; ?>

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
      if(isset($_SESSION['error']) && count($_SESSION['error']) > 0){
        //エラーが存在しているので、表示する
        echo '<ul class="errpr">';
        for($i = 0; $i < count($_SESSION['error']); $i++){
          echo '<li>' . $_SESSION['error'][$i] . '</li>';
        }
        echo '</ul>';
      }
    ?>
    <form name="form1" method="POST" action="confirm.php" enctype="multipart/form-data">
    <dl>
      <dt><label>名前<small>必須</small></label></dt>
      <dd><input type="text" name="name" placeholder="山田太郎" value="<?php if(!empty($_SESSION['name'])){echo $_SESSION['name'];}?>"></dd>
      <dt><label>メールアドレス<small>必須</small></label></dt>
      <dd><input type="email" name="email" required placeholder="mail@example.com" value="<?php if(!empty($_SESSION['email'])){echo $_SESSION['email'];}?>"></dd>
      <dt><label>メールアドレス確認<small>必須</small></label></dt>
      <dd><input type="email" name="reemail" required placeholder="mail@example.com" value="<?php if(!empty($_SESSION['reemail'])){echo $_SESSION['reemail'];}?>"></dd>
      <dt>性別</dt>
      <dd>
        <label>
          <input type="radio" name="gender" value="1" <?php if(empty($_SESSION['gender']) || $_SESSION['gender'] == 1){echo 'checked';}?>>女性
        </label>
        <label>
          <input type="radio" name="gender" value="2" <?php if(empty($_SESSION['gender']) || $_SESSION['gender'] == 2){echo 'checked';}?>>男性
        </label>
        <label>
          <input type="radio" name="gender" value="3" <?php if(empty($_SESSION['gender']) || $_SESSION['gender'] == 3){echo 'checked';}?>>その他
        </label>
      </dd>
      <dt><label for="image">画像ファイル</label></dt>
      <dd><input type="file" name="image" id="image"></dd>
      <dt><label>コメント</label></dt>
      <dd><textarea name="comment" placeholder="コメント内容"><?php if(!empty($_SESSION['comment'])){echo $_SESSION['comment'];}?></textarea></dd>
      <p><input type="submit" value="お問い合わせする"></p>
      </dl>
    </form>
  </main>
</body>
</html>