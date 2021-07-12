<?php
//1. POSTデータ取得
$date   = $_POST["date"];
$plcmt  = $_POST["plcmt"];
$wgt    = $_POST["wgt"];
$mort    = $_POST["mort"];
$procure    = $_POST["procure"];
$procure_n    = $_POST["procure_n"];
$sales    = $_POST["sales"];
$sales_n    = $_POST["sales_n"];
$memo = $_POST["memo"];


//2. DB接続します
//以下を関数化！この二行で、DB接続完了
require_once('funcs_cx.php');
$pdo = db_conn();


//３．SQL文を用意(データ登録：INSERT)
$stmt = $pdo->prepare(
  "INSERT INTO farm( id, date, plcmt, wgt, mort, procure, procure_n, sales, sales_n, memo )
  VALUES( NULL, :date, :plcmt, :wgt, :mort, :procure, :procure_n, :sales, :sales_n, :memo )"
);

// 4. バインド変数を用意
$stmt->bindValue(':date', $date, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':plcmt', $plcmt, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':wgt', $wgt, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':mort', $mort, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':procure', $procure, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':procure_n', $procure_n, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':sales', $sales, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':sales_n', $sales_n, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':memo', $memo, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)

// 5. 実行
$status = $stmt->execute();

//6．データ登録処理後
if($status==false){
    //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
    //以下を関数化
    sql_error($stmt);
  }else{
    //５．index.phpへリダイレクト
    //以下を関数化
    redirect('form.html');
  }