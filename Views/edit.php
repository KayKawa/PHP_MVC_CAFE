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
  $params = $controller->detail();
  $controller->edit($params['contact']['id']);
  $controller->editBack();
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
    <h3>更新画面</h3><br>
    <h6 style="color: red;">*必須入力項目</h6>
    <form action="edit.php?id=<?=$params['contact']['id']?>" method="POST">
      <label for="name">氏名</label><span style="color: red;">*</span>
      <br>
      <?php
        if (isset($_POST['update'])) {
            if ($validationList['name'] !== true) {
                    echo '<dd class="error" style="color:red">' . $validationList['name'] . '</dd>';
            }
        }
        ?>
      <input class="name" type="text"name="name"placeholder="氏名"
      value="<?php echo $params["contact"]["name"]  ?>">
      <span style="color:red" class="alertarea_name"></span>
      <br><br>
      <label for="kana">フリガナ</label><span style="color: red;">*</span>
      <br>
      <?php
        if (isset($_POST['update'])) {
            if ($validationList['kana'] !== true) {
                  echo '<dd class="error" style="color:red">' . $validationList['kana'] . '</dd>';
            }
        }
        ?>
      <input class="kana" type="text"name="kana"placeholder="フリガナ"
      value="<?php echo $params["contact"]["kana"]  ?>">
      <span style="color:red" class="alertarea_kana"></span>
      <br><br>
      <label for="tel">電話番号</label>
      <br>
      <?php
        if (isset($_POST['update'])) {
            if ($validationList['tel'] !== true) {
                  echo '<dd class="error" style="color:red">' . $validationList['tel'] . '</dd>';
            }
        }
        ?>
      <input class="tel" type="text" name="tel"placeholder="電話番号"
      value="<?php echo $params["contact"]["tel"]  ?>">
      <span style="color:red" class="alertarea_tel"></span>
      <br><br>
      <label for="email">メールアドレス</label><span style="color: red;">*</span>
      <br>
      <?php
        if (isset($_POST['update'])) {
            if ($validationList['email'] !== true) {
                echo '<dd class="error" style="color:red">' . $validationList['email'] . '</dd>';
            }
        }
        ?>
      <input class="email" type="text" name="email"placeholder="メールアドレス"
      value="<?php echo $params["contact"]["email"]  ?>">
      <span style="color:red" class="alertarea_email"></span>
      <br><br>
      <label for="body">お問い合わせ内容</label><span style="color: red;">*</span>
      <br>
      <?php
        if (isset($_POST['update'])) {
            if ($validationList['body'] !== true) {
                echo '<dd class="error" style="color:red">' . $validationList['body'] . '</dd>';
            }
        }
        ?>
      <textarea class="body" name="body" placeholder="お問い合わせ内容"
      ><?php echo $params["contact"]["body"]  ?></textarea>
      <br><br>
      <div class="confirm_message">上記の内容でよろしいですか？</div>
      <input type="submit" name="back" value="キャンセル" />
      <input type="submit" name="update" value="更新" />
    </form>
  </div>
</div>

<?php include("footer.php") ?>
