<link rel ="stylesheet" href="CSS/style.css">
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>注文リスト</title>
</head>
<body>
      <h1>ご注文内容</h1>
<?php

//1.データベースへ接続します。
$dns = 'mysql:host=mysql57.ngtssk-work.sakura.ne.jp;dbname=ngtssk-work_sushi_order;charset-utf8mb4';
$username = 'ngtssk-work';
$password = '1145slluuddggee';


if(SUMprice()){
try{
$db = new PDO($dns,$username,$password);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$list = $db->prepare("SELECT * FROM order_sushi WHERE guest_id =(SELECT MAX(guest_id) FROM order_sushi);");
$list->execute();
$i = 1;
if ($list) {
    print "
        <table>

            <tr>
                <th>注文番号</th>
                <th>商品名</th>
                <th>枚数</th>
                <th>金額</th>
                <th>カロリー</th>
            </tr>
    ";
    while ($data = $list->fetch()) {
          print "
                  <tr>
                      <td>{$i}</td>
                      <td>{$data['item']}</td>
                      <td>{$data['count']}皿</td>
                      <td>{$data['price']}円</td>
                      <td>{$data['kcal']}kcal</td>
                  </tr>
";
$i++;
}
  $running_time = floor((SUMkcal() / 8.33));
  print "</table>";
  print "<h1>合計:";
  print number_format(SUMprice());
  print '円</h1>';

  print '<div class = "wrap">
         <label for = "label1"><a>カロリーを表示する<a></label>
         <input type = "checkbox" id= "label1" class="switchbutton">
         <div class= "content">';
  print "<p>およそ";
  print number_format(SUMkcal());
  print "カロリーです。(ランニング時間：";
  print  $running_time;
  print "分相当)</p>";
  print '<img src="img/gym_running.png" width="300">';
  print'</div>
        </div>
        <button type="button" class="flat-button" onclick="history.back(-1)"><a>注文画面</a></button>
        </body>
        </html>';

}} catch (PDOException $e) {
  print "'Could'nt connect to the datebase" . mb_convert_encoding($e->getMessage(), 'UTF-8', 'SJIS-win');
}

}else{
  print '<p>現在、ご注文をお伺いしておりません。<br>注文画面よりご注文をお願いいたします。</p>';
  print'<button type="button" class="flat-button" onclick="history.back(-1)"><a>注文画面</a></button>';
}

//合計金額を算出する。
  function SUMprice(){
  $db = new PDO($GLOBALS['dns'],$GLOBALS['username'],$GLOBALS['password']);
  $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
  $sql = 'SELECT SUM(price) FROM order_sushi WHERE guest_id = (SELECT MAX(guest_id) FROM guest_record)';
  $stmt = $db->prepare($sql);
  $stmt->execute();
  $res = $stmt->fetch();
  return $res['SUM(price)'];
  }
//合計カロリーを算出する。
  function SUMkcal(){
  $db = new PDO($GLOBALS['dns'],$GLOBALS['username'],$GLOBALS['password']);
  $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
  $sql = 'SELECT SUM(kcal) FROM order_sushi WHERE guest_id = (SELECT MAX(guest_id) FROM guest_record)';
  $stmt = $db->prepare($sql);
  $stmt->execute();
  $res = $stmt->fetch();
  return $res['SUM(kcal)'];
  }
  ?>
