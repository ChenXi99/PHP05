<?php
//selsect.phpから処理を持ってくる

//1.対象のIDを取得
$id   = $_GET['id'];

//2.DB接続します
require_once('funcs_cx.php');
$pdo = db_conn();

//3.削除SQLを作成
$stmt = $pdo->prepare("DELETE FROM farm WHERE id = :id");
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute(); //実行

//４．データ登録処理後
if ($status == false) {
    sql_error($stmt);
} else {
    redirect('select_cx.php');
}
