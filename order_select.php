<link rel ="stylesheet" href="CSS/style.css">
<?php
//DB接続情報
$dns = 'mysql:host=mysql57.ngtssk-work.sakura.ne.jp;dbname=ngtssk-work_sushi_order;charset-utf8mb4';
$username = 'ngtssk-work';
$password = '1145slluuddggee';
try{
$db = new PDO($dns,$username,$password);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
print "'Could'nt connect to the datebase" . mb_convert_encoding($e->getMessage(), 'UTF-8', 'SJIS-win');
}

function selectItems() {
global $db;
$sql = "SELECT * FROM menu";
$stmt = $db->prepare($sql);
$stmt->execute();
while ($rows = $stmt->fetch()) {
print '<option value="' . $rows['item_id'] . '">' . $rows['item'] . "</option>";
}
print '</select>';
}

//ここから先はHTMLフォーム
print  '<!DOCTYPE html>';
print  '<html lang="ja">';
print  '<head>';
print  '<meta charset="UTF-8">';
print  '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
print  '<title>注文フォーム</title>';
print  '</head>';
print  '<body>';
print  '<form action="order_check.php" method="POST">';
print '<div class="selection">';
print '<font size="+3">注文フォーム</font>
       <font size="+0.8">（ご注文はこちらからお願いいたします。）</font><br>';
print 'お寿司1⃣:';
print '<select name="sushi_1">';
print '<option value="" hidden>選択してください</option>';
selectItems();
print ' 枚数: <input type="number" min="1" max="3" name="number_1">' . '<br>';
print 'お寿司2⃣:';
print '<select name="sushi_2">';
print '<option value="" hidden>選択してください</option>';
selectItems();
print ' 枚数: <input type="number" min="1" max="3" name="number_2">' . '<br>';
print 'お寿司3⃣:';
print '<select name="sushi_3">';
print '<option value="" hidden>選択してください</option>';
selectItems();
print ' 枚数: <input type="number" min="1" max="3" name="number_3"></div>' . '<br>';

print '<button type="submit" class="flat-button"><a>注文する</a></button>';
print '<button type="reset" value="リセット" class = "reset-button"><a>リセット</a></button>';
print '<a href="order_list.php" class= "check-button">注文確認</a>';
print '<a href="total_check.php" class="confirm-button">会計画面</a>'. '<br>';
print '</form>';
print '<img src="img/menu.png" width="700">';
print '</body>';
print '</html>';
 ?>
