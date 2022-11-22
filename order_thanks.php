<link rel ="stylesheet" href="CSS/style.css">
<?php
// セッションの開始
session_start();

$sushi_1 = htmlspecialchars($_SESSION['sushi_1'], ENT_QUOTES, 'UTF-8');
$sushi_2 = htmlspecialchars($_SESSION['sushi_2'], ENT_QUOTES, 'UTF-8');
$sushi_3 = htmlspecialchars($_SESSION['sushi_3'], ENT_QUOTES, 'UTF-8');
$number_1 = htmlspecialchars($_SESSION['number_1'], ENT_QUOTES, 'UTF-8');
$number_2 = htmlspecialchars($_SESSION['number_2'], ENT_QUOTES, 'UTF-8');
$number_3 = htmlspecialchars($_SESSION['number_3'], ENT_QUOTES, 'UTF-8');


//配列表示
$menu = array("1" => "たこ","2"=>"サーモン","3"=>"ハマチ","4"=>"とろたく","5"=>"たまご","6"=>"ホッキ貝","7"=>"イカ","8"=>"まぐろ","9"=>"炙りサーモン",
"10"=>"イワシ","11"=>"いくら","12"=>"ホタテ","13"=>"うなぎ","14"=>"炙りトロ","15"=>"うに","16"=>"中トロ","17"=>"大トロ");

$price = array("1" => "100","2"=>"100","3"=>"100","4"=>"100","5"=>"100","6"=>"200","7"=>"200","8"=>"200","9"=>"200",
"10"=>"200","11"=>"300","12"=>"300","13"=>"400","14"=>"400","15"=>"500","16"=>"500","17"=>"500");

$kcal = array("1" => "100","2"=>"190","3"=>"130","4"=>"150","5"=>"160","6"=>"120","7"=>"120","8"=>"120","9"=>"190",
"10"=>"100","11"=>"150","12"=>"140","13"=>"180","14"=>"200","15"=>"180","16"=>"200","17"=>"220");

//データベースの接続状況
$dns = 'mysql:host=mysql57.ngtssk-work.sakura.ne.jp;dbname=ngtssk-work_sushi_order;charset-utf8mb4';
$username = 'ngtssk-work';
$password = '1145slluuddggee';

if($number_1 != "" || $number_2 != "" || $number_3 != ""){
//注文1⃣のデータ挿入
if($number_1 != "" && $sushi_1 !=""){
try {
$db = new PDO($dns,$username,$password);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = 'INSERT INTO order_sushi(order_id,guest_id,item_id,item,count,price,kcal)
 VALUES(:order_id,:guest_id,:item_id,:item,:count,:price,:kcal)';

$stmt = $db->prepare($sql);

$order_id = getMaxOrderId() +1;
$guest_id = getGuestID();
$sushiname_1 = $menu[$sushi_1];
$sushiprice_1 = $price[$sushi_1] * $number_1;
$sushikcal_1 = $kcal[$sushi_1] * $number_1;
$stmt->bindValue(':order_id',$order_id);
$stmt->bindValue(':guest_id',$guest_id);
$stmt->bindValue(':item_id',$sushi_1,);
$stmt->bindValue(':item',$sushiname_1);
$stmt->bindValue(':count',$number_1);
$stmt->bindValue(':price',$sushiprice_1);
$stmt->bindValue(':kcal',$sushikcal_1);
$stmt->execute();
} catch (PDOException $e) {
echo "'Could'nt connect to the datebase" . mb_convert_encoding($e->getMessage(), 'UTF-8', 'SJIS-win');
}
}else{
}
if($number_2 != "" && $sushi_2 !=""){
//注文2⃣のデータ挿入
try {
$db = new PDO($dns,$username,$password);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = 'INSERT INTO order_sushi(order_id,guest_id,item_id,item,count,price,kcal)
 VALUES(:order_id,:guest_id,:item_id,:item,:count,:price,:kcal)';

$stmt = $db->prepare($sql);

$order_id = getMaxOrderId() +1;
$guest_id = getGuestID();
$sushiname_2 = $menu[$sushi_2];
$sushiprice_2 = $price[$sushi_2] * $number_2;
$sushikcal_2 = $kcal[$sushi_2] * $number_2;
$stmt->bindValue(':order_id',$order_id);
$stmt->bindValue(':guest_id',$guest_id);
$stmt->bindValue(':item_id',$sushi_2,);
$stmt->bindValue(':item',$sushiname_2);
$stmt->bindValue(':count',$number_2);
$stmt->bindValue(':price',$sushiprice_2);
$stmt->bindValue(':kcal',$sushikcal_2);
$stmt->execute();
} catch (PDOException $e) {
  echo "'Could'nt connect to the datebase" . mb_convert_encoding($e->getMessage(), 'UTF-8', 'SJIS-win');
}
}else{
}
if($number_3 != "" && $sushi_3 !=""){
//注文3⃣のデータ挿入
try {
$db = new PDO($dns,$username,$password);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//データは足してくだけやから
$sql = 'INSERT INTO order_sushi(order_id,guest_id,item_id,item,count,price,kcal)
 VALUES(:order_id,:guest_id,:item_id,:item,:count,:price,:kcal)';

$stmt = $db->prepare($sql);

$order_id = getMaxOrderId() +1;
$guest_id = getGuestID();
$sushiname_3 = $menu[$sushi_3];
$sushiprice_3 = $price[$sushi_3] * $number_3;
$sushikcal_3 = $kcal[$sushi_3] * $number_3;
$stmt->bindValue(':order_id',$order_id);
$stmt->bindValue(':guest_id',$guest_id);
$stmt->bindValue(':item_id',$sushi_3,);
$stmt->bindValue(':item',$sushiname_3);
$stmt->bindValue(':count',$number_3);
$stmt->bindValue(':price',$sushiprice_3);
$stmt->bindValue(':kcal',$sushikcal_3);
$stmt->execute();
} catch (PDOException $e) {
echo "'Could'nt connect to the datebase" . mb_convert_encoding($e->getMessage(), 'UTF-8', 'SJIS-win');
}
}else{
}
print '<!DOCTYPE HTML>
 <html lang="ja">
 <head>
 <meta charset="utf-8">
 <title>注文確定ページ</title>
 <style>
 p {
   margin-left: 50px;
 }
 </style>
 </head>
 <body>
 <p>ご注文ありがとうございました！</p>
 <a href="order_select.php" class = "flat-button">注文画面へ戻る</a>
 </body>
 </html>';
}else{
  print "<p>注文エラーが発生しました。店員が参りますので少々お待ちください。</p>";
}


function getMaxOrderId(){
  $db = new PDO($GLOBALS['dns'],$GLOBALS['username'],$GLOBALS['password']);
  $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

  $sql = 'SELECT MAX(order_id) AS max_id from order_sushi;';
  $stmt = $db->prepare($sql);
  $stmt->execute();
  $res = $stmt->fetch();
  return $res['max_id'];
}

function getGuestID(){
  $db = new PDO($GLOBALS['dns'],$GLOBALS['username'],$GLOBALS['password']);
  $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
  $sql = 'SELECT MAX(guest_id) AS max_id from guest_record;';
  $stmt = $db->prepare($sql);
  $stmt->execute();
  $res = $stmt->fetch();
  return $res['max_id'];
}


 ?>
