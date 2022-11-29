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
<?php
  require_once(ROOT_PATH.'/Controllers/ContactController.php');
  $controller = new ContactController();
  $controller->confirm();
  $controller->back();
  $validationList = $_SESSION['validationList'];
  $validationFlag = $_SESSION['validationFlag'];
?>
<?php include("header.php") ?>

<h1>お問い合わせ入力画面</h1><br>
<form action="confirm.php" method="POST">
<dl>
  <dt>氏名</dt>
  <dd>
  <?php
    echo $_SESSION["name"]."<br>";
    ?>
  </dd>

  <dt>フリガナ</dt>
  <dd>
  <?php
    echo $_SESSION["kana"]."<br>";
    ?>
  </dd>

  <dt>電話番号</dt>
  <dd>
  <?php
    echo $_SESSION["tel"]."<br>";
    ?>
  </dd>

  <dt>メールアドレス</dt>
  <dd>
  <?php
    echo $_SESSION["email"]."<br>";
    ?>
  </dd>

  <dt>お問い合わせ内容</dt>
  <dd>
  <?php
    echo nl2br($_SESSION["body"])."<br>";
    ?>
  </dd>
</dl>
<div>
<div class="confirm_message">上記の内容でよろしいですか？</div>
<input type="submit" name="back" value="キャンセル" />
<input type="submit" name="confirm" value="送信" />
</div>

</form>
<?php include("footer.php") ?>
