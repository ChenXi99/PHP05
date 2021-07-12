<?php
//selsect.phpから処理を持ってくる
//1.外部ファイル読み込みしてDB接続(funcs.phpを呼び出して)
require_once('funcs_cx.php');

loginCheck();

$pdo = db_conn();

//2.対象のIDを取得
$id = $_GET["id"];

//3．データ取得SQLを作成（SELECT文）
$stmt = $pdo->prepare("SELECT * FROM farm WHERE id=:id");
$stmt->bindValue(':id',$id,PDO::PARAM_INT);

//実行
$status = $stmt->execute();

//4．データ表示
$view = "";
if ($status == false) {
    sql_error($status);
} else {
    $result = $stmt->fetch();
}

?>

<!-- 以下はform.htmlのHTMLをまるっと持ってくる -->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form</title>
    <link href="form1.css" rel="stylesheet">
</head>
<body>

<!-- Head[Start] -->
<header>
        <nav class="">
          <div class="container">
          <div class="navbar-header"><a href="select_cx.php">飼育DB</a></div>
          <div class="navbar-header"><a href="login_cx.php">ログイン</a></div>
          <div class="navbar-header"><a href="logout_cx.php">ログアウト</a></div>
          </div>
        </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->

 <!-- method, action, 各inputのnameを確認してください。  -->
 <form method="POST" action="update_cx.php">
    <div class="jumbotron">
        <fieldset>
            <legend>飼育日記🐤</legend>
            <label>日付<input type="date" name="date" value="<?= $result['date']?>"></label><br>
            <label>入雛<input type="number" name="plcmt" value="<?= $result['plcmt']?>"></label>羽<br>
            <label>体重<input type="number" name="wgt" value="<?= $result['wgt']?>"></label>kg<br>
            <label>死鳥<input type="number" name="mort" value="<?= $result['mort']?>"></label>羽<br>
            <label>仕入</label>
                <select name="procure" style="width: 100px;" value="<?= $result['procure']?>">
                    <option value="飼料">飼料</option>
                    <option value="雛">雛</option>
                    <option value="薬品">薬品</option>
                    <option value="備品">備品</option>
                    <option value="スタッフ">スタッフ</option>
                    <option value="その他">その他</option>
                </select><input type="number" name="procure_n" value="<?= $result['procure_n']?>">円<br>
            <label>売上</label>
            <select name="sales" style="width: 100px;" value="<?= $result['sales']?>">
                <option value="生鳥出荷">生鳥</option>
                <option value="タンドリー出荷">タンドリー</option>
            </select><input type="number" name="sales_n" value="<?= $result['sale_n']?>">円<br>
            
            <label>メモ<textarea name="memo" rows="4" cols="40"><?= $result['memo']?></textarea></label><br>
            <input type="hidden" name="id" value="<?= $result['id']?>"> //見えないデータを載せる
            <input type="submit" value="送信" style="margin-left: 180px;">
        </fieldset>

        <a href="select_cx.php">データ表示</a>

    </div>
</form>


</body>
</html>