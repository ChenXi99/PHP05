<?php
// 1. DB接続
require_once('funcs_cx.php');
$pdo = db_conn();

//２．データ登録SQL作成
$stmt = $pdo->prepare("SELECT * FROM gs_img_table");
$status = $stmt->execute();

//３．データ表示
$view="";
if($status==false) {
  sql_error();
}else{
  while( $r = $stmt->fetch(PDO::FETCH_ASSOC)){ 
    $view .= $r["date"];
    $view .= '<p><img src="upload/'.$r["img"].'"></p><br>';
  }
}

?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>アップロード一覧</title>
    <title>
    </title>
    <style>
        #photarea {
            padding: 2%;
            width: 90%;
            background:none;
        }

        img {
            width: 400px
        }

        #upload_btn {
            display: none;
        }
    </style>
    <link href="form1.css" rel="stylesheet">
</head>

<body id="main">

    <!-- ヘッダー -->
    <header>
        <nav class="container_wrap">
          <div class="container">
          <div class="navbar-header"><a class="a_nav" href="select_cx.php">飼育DB</a></div>
          <div class="navbar-header"><a class="a_nav" href="form.html">飼育日記🐤</a></div>
          <div class="navbar-header"><a class="a_nav" href="login_cx.php">ログイン</a></div>
          <div class="navbar-header"><a class="a_nav" href="logout_cx.php">ログアウト</a></div>
          </div>
        </nav>
    </header>
    <!-- ヘッダー -->

    <!-- コンテンツ -->
    <div class="container-fluid">
        
        <div id="photarea">
            <!-- ここにPHPの変数を記述 -->
            <?=$view?>
        </div>
    </div>
    <!-- コンテンツ -->

    <script src="js/jquery-2.1.3.min.js"></script>

</body>

</html>