<script type="text/javascript">
document.addEventListener('DOMContentLoaded', function() {
  // 氏名10文字以内（半角、全角区別なし）
  var targets = document.getElementsByClassName('name');
    for (var i=0 ; i<targets.length ; i++) {
      // ▼文字が入力されたタイミングでチェックする：
      targets[i].oninput = function () {
        var alertelement = this.parentNode.getElementsByClassName('alertarea_name');
        if( ( this.value != '') && ( this.value.length > 10) ) {
          // ▼何か入力があって、指定以外の文字があれば
          if( alertelement[0] ) { alertelement[0].innerHTML = '氏名は、10文字以内で入力して下さい。'; }
          this.style.border = "2px solid red";
        }
        else {
          // ▼何も入力がないか、または指定文字しかないなら
          if( alertelement[0] ) { alertelement[0].innerHTML = ""; }
          this.style.border = "1px solid black";
        }
      }
    }
    // フリガナ10文字以内（半角、全角区別なし）
  var targets = document.getElementsByClassName('kana');
    for (var i=0 ; i<targets.length ; i++) {
      // ▼文字が入力されたタイミングでチェックする：
      targets[i].oninput = function () {
        var alertelement = this.parentNode.getElementsByClassName('alertarea_kana');
        if( ( this.value != '') && ( this.value.length > 10) ) {
          // ▼何か入力があって、指定以外の文字があれば
          if( alertelement[0] ) { alertelement[0].innerHTML = 'フリガナは、10文字以内で入力して下さい。'; }
          this.style.border = "2px solid red";
        }
        else {
          // ▼何も入力がないか、または指定文字しかないなら
          if( alertelement[0] ) { alertelement[0].innerHTML = ""; }
          this.style.border = "1px solid black";
        }
      }
    }
  // 電話番号バリデーション
  var tel = document.getElementsByClassName('tel');
  for (var i=0 ; i<tel.length ; i++) {
    // ▼文字が入力されたタイミングでチェックする：
    tel[i].oninput = function () {
      var alertelement = this.parentNode.getElementsByClassName('alertarea_tel');
      if( ( this.value != '') && ( this.value.match( /[^0-9]+/ )) ) {
        // ▼何か入力があって、指定以外の文字があれば
        if( alertelement[0] ) { alertelement[0].innerHTML = '電話番号には、0~9の数字だけが使えます。'; }
        this.style.border = "2px solid red";
      }
      else {
        // ▼何も入力がないか、または指定文字しかないなら
        if( alertelement[0] ) { alertelement[0].innerHTML = ""; }
        this.style.border = "1px solid black";
      }
    }
  }
  // メールアドレスバリデーション
  var targets = document.getElementsByClassName('email');
  for (var i=0 ; i<targets.length ; i++) {
    // ▼文字が入力されたタイミングでチェックする：
    targets[i].oninput = function () {
      var alertelement = this.parentNode.getElementsByClassName('alertarea_email');
      if( ( this.value != '') && ( !this.value.match(/^[a-z]+[a-z0-9_-]+@[a-z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/i)) ) {
        // ▼何か入力があって、指定以外の文字があれば
        if( alertelement[0] ) { alertelement[0].innerHTML = 'メールアドレスは、xxx@xxx.xx形式で入力して下さい。'; }
        this.style.border = "2px solid red";
      }
      else {
        // ▼何も入力がないか、または指定文字しかないなら
        if( alertelement[0] ) { alertelement[0].innerHTML = ""; }
        this.style.border = "1px solid black";
      }
    }
  }
});
</script>
<?php
  require_once(ROOT_PATH.'/Controllers/ContactController.php');
  $controller = new ContactController();
  $controller->create();
  $params = $controller->getContents();
  $deleteParams = $controller->delete();
  $validationList = $_SESSION['validationList'];
  $validationFlag = $_SESSION['validationFlag'];
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Casteria</title>
    <link rel="stylesheet" type="text/css" href="../css/base.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.0.7/css/swiper.min.css" />
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <script defer src="../js/index.js"></script>
</head>
<?php include("header.php") ?>
<div class="container">
  <div class="left_container">
    <h3>お問い合わせ入力画面</h3><br>
    <h6 style="color: red;">*必須入力項目</h6>
    <form action="contact.php" method="POST">
      <label for="name">氏名</label><span style="color: red;">*</span>
      <br>
      <?php
        if (isset($_POST['submit'])) {
            if ($validationList['name'] !== true) {
                    echo '<dd class="error" style="color:red">' . $validationList['name'] . '</dd>';
            }
        }
        ?>
      <input class="name" type="text"name="name"placeholder="氏名"
      value="<?php echo isset($_SESSION["name"]) ? $_SESSION["name"] : ''; ?>">
      <span style="color:red" class="alertarea_name"></span>
      <br><br>
      <label for="kana">フリガナ</label><span style="color: red;">*</span>
      <br>
      <?php
        if (isset($_POST['submit'])) {
            if ($validationList['kana'] !== true) {
                  echo '<dd class="error" style="color:red">' . $validationList['kana'] . '</dd>';
            }
        }
        ?>
      <input class="kana" type="text"name="kana"placeholder="フリガナ"
      value="<?php echo isset($_SESSION["kana"]) ? $_SESSION["kana"] : ''; ?>">
      <span style="color:red" class="alertarea_kana"></span>
      <br><br>
      <label for="tel">電話番号</label>
      <br>
      <?php
        if (isset($_POST['submit'])) {
            if ($validationList['tel'] !== true) {
                  echo '<dd class="error" style="color:red">' . $validationList['tel'] . '</dd>';
            }
        }
        ?>
      <input class="tel" type="text" name="tel"placeholder="電話番号"
      value="<?php echo isset($_SESSION["tel"]) ? $_SESSION["tel"] : ''; ?>">
      <span style="color:red" class="alertarea_tel"></span>
      <br><br>
      <label for="email">メールアドレス</label><span style="color: red;">*</span>
      <br>
      <?php
        if (isset($_POST['submit'])) {
            if ($validationList['email'] !== true) {
                echo '<dd class="error" style="color:red">' . $validationList['email'] . '</dd>';
            }
        }
        ?>
      <input class="email" type="text" name="email"placeholder="メールアドレス"
      value="<?php echo isset($_SESSION["email"]) ? $_SESSION["email"] : ''; ?>">
      <span style="color:red" class="alertarea_email"></span>
      <br><br>
      <label for="body">お問い合わせ内容</label><span style="color: red;">*</span>
      <br>
      <?php
        if (isset($_POST['submit'])) {
            if ($validationList['body'] !== true) {
                echo '<dd class="error" style="color:red">' . $validationList['body'] . '</dd>';
            }
        }
        ?>
      <textarea class="body" name="body" placeholder="お問い合わせ内容"
      ><?php echo (isset($_SESSION["body"])) ? $_SESSION["body"] : ''; ?></textarea>
      <br><br>
      <input type="submit" name="submit">
    </form>
  </div>
  <div class="right_container">
    <h3>お問い合わせ結果</h3><br>
    <table>
      <tr>
        <th>氏名</th>
        <th>フリガナ</th>
        <th>電話番号</th>
        <th>メールアドレス</th>
        <th>お問い合わせ内容</th>
        <th>更新</th>
        <th>削除</th>
      </tr>
      <?php foreach ($params['contacts'] as $contact) : ?>
      <tr>
        <td><?php echo $contact["name"] ?></td>
        <td><?php echo $contact["kana"] ?></td>
        <td><?php echo $contact["tel"] ?></td>
        <td><?php echo $contact["email"] ?></td>
        <td><?php echo nl2br($contact["body"]) ?></td>
        <td>
        <button type="button" onclick="location.href='/edit.php?id=<?php echo $contact['id'] ?>'">更新</button>
        </td>
        <td>
        <form action="contact.php" method="post" onSubmit="return check()">
          <input type="hidden" name="delete_id" value="<?php echo $contact["id"]; ?>">
          <input type="submit" value="削除" name="delete">
        </form>
        </td>
      </tr>
      <?php endforeach;  ?>
    </table>
  </div>
</div>
<script>
  function check(){

if(window.confirm('上記の内容でよろしいですか？')){ // 確認ダイアログを表示
  return true; // 「OK」時は送信を実行
}
else{ // 「キャンセル」時の処理
  window.alert('キャンセルされました'); // 警告ダイアログを表示
  return false; // 送信を中止
}

}
</script>
<?php include("footer.php") ?>
