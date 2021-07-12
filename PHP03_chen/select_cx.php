<?php
//SESSIONスタート
session_start();

//関数を呼び出す
require_once('funcs_cx.php');

//ログインチェック
loginCheck();
$user_name = $_SESSION['name'];

//以下ログインユーザーのみ

$pdo = db_conn();

//２．データ登録SQL作成
$stmt = $pdo->prepare("SELECT * FROM farm ORDER BY `farm`.`date` ASC");
$status = $stmt->execute();

//関数定義＆データ表示
$date_chart = '';
$wgt_chart = '';
$mort_chart = '';
$sales_ttl = '';
$procure_ttl = '';
$profit = '';
$plcmt_ttl = '';
$mort_ttl = '';
$mort_ttl_r = '';

// $sales_ttl = number_format($sales_ttl);
// $procure_ttl = number_format($procure_ttl);
// $profit_ttl = number_format($profit_ttl);

//３．データ表示
$view = "";
if ($status == false) {
    sql_error($status);
} else {
    while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        //GETデータ送信リンク作成
        // <a>で囲う。
        $date = h($result['date']);
        $plcmt = h($result['plcmt']);
        $wgt = h($result['wgt']);
        $mort = h($result['mort']);
        $procure = h($result['procure']);
        $procure_n = h($result['procure_n']);
        $sales = h($result['sales']);
        $sales_n = h($result['sales_n']);
        $memo = h($result['memo']);

        $data .= "<tr><td>";
        $data .= '<a href="detail_cx.php?id='.$result["id"].'">';
        $data .= $date;
        $data .= '<a href="delete_cx.php?id='.$result["id"].'">';
        $data .= "×";
        $data .= "</td><td>";
        $data .= $plcmt;
        $data .= "</td><td>";
        $data .= $wgt;
        $data .= "</td><td>";
        $data .= $mort;
        $data .= "</td><td>";
        $data .= $procure;
        $data .= "</td><td>";
        $data .= $procure_n;
        $data .= "</td><td>";
        $data .= $sales;
        $data .= "</td><td>";
        $data .= $sales_n;
        $data .= "</td><td>";
        $data .= $memo;
        $data .= '</a>';
        $data .= "</td></tr>";
        
        $date_chart = $date_chart . '"'. $date.'",';
        $wgt_chart = $wgt_chart . '"'. $wgt.'",';
        $mort_chart = $mort_chart . '"'. $mort.'",';
        $sales_ttl = $sales_ttl + $sales_n;
        $procure_ttl = $procure_ttl + $procure_n;
        $profit = $sales_ttl - $procure_ttl;
        $plcmt_ttl = $plcmt_ttl + $plcmt;
        $mort_ttl = $mort_ttl + $mort;
        $mort_ttl_r = 100 - ($mort_ttl / $plcmt_ttl * 100);

    }
    $date_chart = trim($date_chart,",");
    $wgt_chart = trim($wgt_chart,",");
    $mort_chart = trim($mort_chart,",");
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>データ表示</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="form1.css" rel="stylesheet">
    
</head>

<body id="main">
    <!-- Head[Start] -->
    <header>
        <nav class="container_wrap">
          <div class="container">
          <div class="navbar-header"><a class="a_nav" href="form.html">飼育日記🐤</a></div>
          </div>
        </nav>
    </header>
    <!-- Head[End] -->

    <!-- Main[Start] -->
            <a href="detail_cx.php"></a>

    <div class="wrap">
        <div class="wrap1">
            <table border='1' id="list">
                <tr><td class="t">日付</td>
                <td class="t">入雛</td>
                <td class="t">体重</td>
                <td class="t">死鳥</td>
                <td class="t">仕入</td>
                <td class="t">金額</td>
                <td class="t">売上</td>
                <td class="t">金額</td>
                <td class="t">メモ</td></tr>
                <?= $data ?>
            </table>
        </div>
        <div class="wrap2" style="width:500px; ">
            <div class="pl">
                    <p>売上： <?php echo number_format($sales_ttl) ?> 円</p>
                    <p>仕入： <?php echo number_format($procure_ttl) ?> 円</p>
                    <p>利益： <?php echo number_format($profit) ?> 円</p>
                    <p>育成率：<?php echo number_format($mort_ttl_r,1) ?> ％</p>
            </div>
            
            <canvas id="Chart_wgt" width="420px"></canvas>
            <canvas id="Chart_mort" width="420px"></canvas>
        </div>

    </div>

    <!-- Main[End] -->

    <script>
    var ctx = document.getElementById('Chart_wgt').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [<?php echo $date_chart ?>],//日付
            datasets: [{
                label: '体重推移 (g)',
                data: [<?php echo $wgt_chart ?>],//体重
                backgroundColor: [
                    'rgba(255, 206, 86, 0.2)',
                ],
                borderColor: [
                    'rgba(255, 206, 86, 1)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
    </script>

<script>
    var ctx = document.getElementById('Chart_mort').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [<?php echo $date_chart ?>],//日付
            datasets: [{
                label: '死鳥推移 (羽)',
                data: [<?php echo $mort_chart ?>],//死鳥
                fill: false,
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
    </script>

</body>

</html>