<link rel ="stylesheet" href="CSS/style.css">
<?PHP
// セッションの開始
session_start();
$price = htmlspecialchars($_SESSION['price'], ENT_QUOTES, 'UTF-8');
$discounted = htmlspecialchars($_SESSION['discounted'], ENT_QUOTES, 'UTF-8');
$coupon = htmlspecialchars($_SESSION['coupon'], ENT_QUOTES, 'UTF-8');
$payment = htmlspecialchars($_SESSION['payment'], ENT_QUOTES, 'UTF-8');

$coupon_name = array("" => "-","TUES10"=>"火曜日割引","CREDI5"=>"キャッシュレス決済","HOKKAIDO25"=>"北海道いくらフェア");

//DB接続情報
$dns ='mysql:host=mysql57.ngtssk-work.sakura.ne.jp;dbname=ngtssk-work_sushi_order;charset-utf8mb4';
$username = 'ngtssk-work';
$password = '1145slluuddggee';

//1⃣テーブル'guest_record'の確定入力(お客様の退店時間、会計番号、会計金額を入力する。)
try{
$db = new PDO($dns,$username,$password);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = 'UPDATE guest_record SET exit_time = CURRENT_TIME,total_id = :total_id,total_cost = :price
        WHERE guest_id = (SELECT MAX(guest_id) FROM order_sushi);';
$stmt = $db->prepare($sql);
$total_id = getMaxTotalId();
$stmt->bindValue(':total_id',$total_id);
$stmt->bindValue(':price',$price);
$stmt->execute();
} catch (PDOException $e) {
print "'Could'nt connect to the datebase" . mb_convert_encoding($e->getMessage(), 'UTF-8', 'SJIS-win');
}

//2⃣テーブル'total_sushi'の入力
try{
$db = new PDO($dns,$username,$password);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = 'INSERT INTO total_sushi(total_id,guest_id,accounting,payment,coupon_id,discounted_price,total_cost)
 VALUES(:total_id,:guest_id,CURRENT_TIMESTAMP,:payment,:coupon_id,:discounted_price,:total_cost)';

$stmt = $db->prepare($sql);
$total_id = getMaxTotalId() +1;
$guest_id = getGuestID();
$stmt->bindValue(':total_id',$total_id);
$stmt->bindValue(':guest_id',$guest_id);
$stmt->bindValue(':payment',$payment);
$stmt->bindValue(':coupon_id',$coupon);
$stmt->bindValue(':discounted_price',$discounted);
$stmt->bindValue(':total_cost',$price);
$stmt->execute();
} catch (PDOException $e) {
print "'Could'nt connect to the datebase" . mb_convert_encoding($e->getMessage(), 'UTF-8', 'SJIS-win');
}

//3⃣テーブル'coupon_sushi'の入力
if($coupon != null){
try{
$db = new PDO($dns,$username,$password);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = 'INSERT INTO coupon_sushi(coupon_date,coupon_id,coupon_name,coupon_use,guest_id,total_id,discounted_price)
 VALUES(:coupon_date,:coupon_id,:coupon_name,CURRENT_DATE,:guest_id,:total_id,:discounted_price)';

$stmt = $db->prepare($sql);
$coupon_date = getMAXCouponDate()+1;
$total_id = getMaxTotalId();
$guest_id = getGuestID();
$stmt->bindValue(':coupon_date',$coupon_date);
$stmt->bindValue(':coupon_id',$coupon);
$stmt->bindValue(':coupon_name',$coupon_name[$coupon]);
$stmt->bindValue(':guest_id',$guest_id);
$stmt->bindValue(':total_id',$total_id);
$stmt->bindValue(':discounted_price',$discounted);
$stmt->execute();
} catch (PDOException $e) {
print "'Could'nt connect to the datebase" . mb_convert_encoding($e->getMessage(), 'UTF-8', 'SJIS-win');
}
}else{
}



//↓↓ function関数まとめ ↓↓
function getMaxTotalId(){
  $db = new PDO($GLOBALS['dns'],$GLOBALS['username'],$GLOBALS['password']);
  $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

  $sql = 'SELECT MAX(total_id) AS max_id from total_sushi;';
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

function getMAXCouponDate(){
  $db = new PDO($GLOBALS['dns'],$GLOBALS['username'],$GLOBALS['password']);
  $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
  $sql = 'SELECT MAX(coupon_date) AS max_id from coupon_sushi;';
  $stmt = $db->prepare($sql);
  $stmt->execute();
  $res = $stmt->fetch();
  return $res['max_id'];
}
//↑↑ functinon まとめ ↑↑



?>

<!DOCTYPE HTML>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>ご来店ありがとうございました。</title>
<META http-equiv="Refresh" content="5;URL=entering.php">
</head>
<body>
<p>ご来店ありがとうございました。またのお越しをお待ちしております。</p>
</body>
</html>
