<link rel ="stylesheet" href="CSS/style.css">
<?php
//1.データベースへ接続します。
$dns = 'mysql:host=mysql57.ngtssk-work.sakura.ne.jp;dbname=ngtssk-work_sushi_order;charset-utf8mb4';
$username = 'ngtssk-work';
$password = '1145slluuddggee';

if ($_SERVER['REQUEST_METHOD']  == 'POST'){
  if($form_errors = validate_form()){
    show_form($form_errors);
  } else {
    process_form();
  }
}
 else {
  show_form();
 }
 function process_form(){
  proceed_check2();
 }

function show_form($errors = ''){
  if($errors != ""){
    print '<p>エラーが発生しました。</p><ul><li>';
    print implode('</li><li>',$errors);
    print '</li></ul>';
  }
  first_check();
}

function first_check(){
print '<!DOCTYPE html>
 <html lang="ja">
 <head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>お会計確認画面</title>
 </head>
 <body>
 <form method="POST" action="' . $_SERVER['PHP_SELF'] . '">';
print '<div class="payment-coupon"><font size="+3">お支払方法を選択してください。</font><br>
<label for  "payment">お支払方法:</label><br>
<input type="radio" name="payment" value="1">現金
<input type="radio" name="payment" value="2">クレジットカード<br>
<label for "coupon">クーポンコード:</label><br>
<input id="coupon" name="coupon" size="20" maxlength="15"></div><br>
<a href="order_select.php" class= "flat-button">戻る</a>
<button type="submit" class = "confirm-button">お会計</button>
</form>
</body>
</html>';
}

function validate_form(){
  $errors = array();
  $couponcodeA = 'TUES10';
  $couponcodeB = 'CREDI5';
  $couponcodeC = 'HOKKAIDO25';
  $couponcodeD = "";
  $date = date('w');

  //支払方法を選択していない場合
  if(empty($_POST['payment'])) {
    $errors[] = 'お支払方法を選択してください。';
  }
  //クーポンコードが間違っている場合
  if (($_POST['coupon'] != $couponcodeA) && ($_POST['coupon'] != $couponcodeB)
  && ($_POST['coupon'] != $couponcodeC) && ($_POST['coupon'] != $couponcodeD)) {
  $errors[] = 'クーポンを正しく入力してください。';
  }
  //クーポンコード'CRECI5'が利用出来ない場合
  elseif (($_POST['coupon'] == $couponcodeB) && ($_POST['payment']=="1")){
  $errors[] = '現金払いでは利用できないクーポンです。';
  }
  //クーポンコード'TUES10'が利用できない場合
  elseif (($_POST['coupon'] == $couponcodeA) && ($date != "2")){
  $errors[] = '本日は対象曜日でないため利用できないクーポンです。';
  }
  //注文がない場合
  elseif (SUMprice()== 0){
  $errors[] = 'ご注文を承っておりません。１皿以上ご注文をお願いいたします。';
  }
 return $errors;
}

function proceed_check2(){

print'<!DOCTYPE html>
 <head>
 <html lang="ja">
<title>お会計確認画面</title>
 </head>
 <body>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
<div class="total"> <font size="+3">お支払金額</font><br>
<form action="total_thanks.php" method="post">';
print "お会計価格は";
if ($_POST['coupon'] == "TUES10"){
  $price = number_format(SUMprice() * 0.90);
  print $price;
  print "円です。<br>";
  print '<a>(火曜日割引価格:△';
  $discounted = number_format(SUMprice()*0.10);
  print $discounted;
  print '円)</a>';
}elseif($_POST['coupon'] == "CREDI5"){
  $price = number_format(SUMprice() * 0.95);
  print $price;
  print "円です。<br>";
  print '<a>(キャッシュレス決済割引価格:△';
  $discounted = number_format(SUMprice()*0.05);
  print $discounted;
  print '円)</a>';
}elseif($_POST['coupon'] == "HOKKAIDO25"){
  $price = number_format((SUMprice() - (IKURAprice()*0.25)));
  print $price;
  print "円です。<br>";
  print '<a>(北海道(いくら)フェア割引価格:△';
  $discounted = number_format(IKURAprice()*0.25);
  print $discounted;
  print '円)</a>';
}else{
  $price = number_format(SUMprice());
  print $price;
  print "円です。<br>";
  $discounted = 0;
}
print "</div>";
print "<br>";
print '<a href="order_select.php" class= "flat-button">戻る</a>
<button type="submit" class="confirm-button">会計確定する</button>
</form>
</body>
</html>';

//セッション開始
session_start();
$_SESSION['price'] = htmlspecialchars($price, ENT_QUOTES, 'UTF-8');
$_SESSION['discounted'] = htmlspecialchars($discounted, ENT_QUOTES, 'UTF-8');
$_SESSION['coupon'] = htmlspecialchars($_POST['coupon'], ENT_QUOTES, 'UTF-8');
$_SESSION['payment'] = htmlspecialchars($_POST['payment'], ENT_QUOTES, 'UTF-8');
}

function SUMprice(){
$db = new PDO($GLOBALS['dns'],$GLOBALS['username'],$GLOBALS['password']);
$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
$sql = 'SELECT SUM(price) FROM order_sushi WHERE guest_id = (SELECT MAX(guest_id) FROM guest_record)';
$stmt = $db->prepare($sql);
$stmt->execute();
$res = $stmt->fetch();
return $res['SUM(price)'];
}

function IKURAprice(){
$db = new PDO($GLOBALS['dns'],$GLOBALS['username'],$GLOBALS['password']);
$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
$sql = 'SELECT SUM(price) FROM order_sushi WHERE guest_id = (SELECT MAX(guest_id) FROM guest_record) AND item = "いくら"';
$stmt = $db->prepare($sql);
$stmt->execute();
$res = $stmt->fetch();
return $res['SUM(price)'];
}


?>
