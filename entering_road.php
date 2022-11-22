<link rel ="stylesheet" href="CSS/style.css">
<?php
//DB接続情報
$dns ='mysql:host=mysql57.ngtssk-work.sakura.ne.jp;dbname=ngtssk-work_sushi_order;charset-utf8mb4';
$username = 'ngtssk-work';
$password = '1145slluuddggee';

if(check1()){
 entering();

}elseif(check2()){
  entering();
  }else{
print'<html>
    <head>
    <title>入店エラー</title>
    </head>
    <body>';
    print '<p>会計処理が完了していません。店員が確認に参りますので少々お待ちください。</p>';
    print'</body>
    </head>';
  }

//会員番号を取得する。
function getMaxId(){
$db = new PDO($GLOBALS['dns'],$GLOBALS['username'],$GLOBALS['password']);
$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

$sql = 'SELECT MAX(guest_id) AS max_id from guest_record;';
$stmt = $db->prepare($sql);
$stmt->execute();
$res = $stmt->fetch();
return $res['max_id'];
}

//前回の会計処理が完了しているかの確認をする。
function check1(){
$db = new PDO($GLOBALS['dns'],$GLOBALS['username'],$GLOBALS['password']);
$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
$sql = 'SELECT exit_time FROM guest_record WHERE guest_id = (SELECT MAX(guest_id) FROM guest_record)';
$stmt = $db->prepare($sql);
$stmt->execute();
$res = $stmt->fetch();
if($res['exit_time']!=null){
  return true;
}
return false;
}

function check2(){
$db = new PDO($GLOBALS['dns'],$GLOBALS['username'],$GLOBALS['password']);
$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
$sql = 'SELECT * FROM guest_record';
$stmt = $db->prepare($sql);
$stmt->execute();
$res = $stmt->fetch();
if($res['guest_id'] == null){
  return true;
}
return false;
}

function entering(){
  print'<html>
  <head>
  <title>注文へ移動中</title>
  <META http-equiv="Refresh" content="2;URL=order_select.php">
  </head>
  <body>
  <p>注文フォームへ移動しています。少々お待ちください。</p>
  </body>
  </head>';

  try{
  $db = new PDO($GLOBALS['dns'],$GLOBALS['username'],$GLOBALS['password']);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  //データは足してくだけやから
  $sql = 'INSERT INTO guest_record(guest_id,seat_no,date_of_visit,entering_time)
   VALUES(:guest_id,:seat_no,CURRENT_DATE,CURRENT_TIME)';

  $stmt = $db->prepare($sql);
  $guest_id = getMaxId() +1;
  $stmt->bindValue(':guest_id',$guest_id);
  $stmt->bindValue(':seat_no',23);
  $stmt->execute();

  } catch (PDOException $e) {
  print "'Could'nt connect to the datebase" . mb_convert_encoding($e->getMessage(), 'UTF-8', 'SJIS-win');
  }
}
?>
