<link rel ="stylesheet" href="CSS/style.css">
<?php
// フォームのボタンが押されたら
if ($_SERVER["REQUEST_METHOD"] == "POST") {
// フォームから送信されたデータを各変数に格納
$sushi_1 = $_POST["sushi_1"];
$sushi_2 = $_POST["sushi_2"];
$sushi_3 = $_POST["sushi_3"];
$number_1 = $_POST["number_1"];
$number_2 = $_POST["number_2"];
$number_3 = $_POST["number_3"];
}

//メニューから連想配列する。
$menu = array("1" => "たこ","2"=>"サーモン","3"=>"ハマチ","4"=>"とろたく","5"=>"たまご","6"=>"ホッキ貝","7"=>"イカ",
"8"=>"まぐろ","9"=>"炙りサーモン","10"=>"イワシ","11"=>"いくら","12"=>"ホタテ","13"=>"うなぎ","14"=>"炙りトロ","15"=>"うに",
"16"=>"中トロ","17"=>"大トロ");

//セッション開始
session_start();
$_SESSION['sushi_1'] = htmlspecialchars($sushi_1, ENT_QUOTES, 'UTF-8');
$_SESSION['sushi_2'] = htmlspecialchars($sushi_2, ENT_QUOTES, 'UTF-8');
$_SESSION['sushi_3'] = htmlspecialchars($sushi_3, ENT_QUOTES, 'UTF-8');
$_SESSION['number_1'] = htmlspecialchars($number_1, ENT_QUOTES, 'UTF-8');
$_SESSION['number_2'] = htmlspecialchars($number_2, ENT_QUOTES, 'UTF-8');
$_SESSION['number_3'] = htmlspecialchars($number_3, ENT_QUOTES, 'UTF-8');
?>
 <html lang="ja">
 <head>
 <meta charset="UTF-8">
 <title>注文確認画面</title>
 </head>
 <body>
 <div>
 <form action="order_thanks.php" method="post">
   <h1 class="contact-title">ご注文内容確認</h1>


<?PHP
      if (($number_1 != "" && $sushi_1 !="") || ($number_2 != "" && $sushi_2 !="") || ($number_3 != "" && $sushi_3 !="")){
print'<p>ご注文はこちらで宜しいでしょうか？<br>よろしければ「注文確定」ボタンを押して下さい。</p>';

print '<div>';
print '----------------------------------------';
      if ($number_1 != "" && $sushi_1 !=""){
print '<input type="hidden" name="sushi_1" value="';
print $menu[$sushi_1];
print '">';
print '<input type="hidden" name="number_1" value="';
print $number_1;
print '">';
print '<div><label>注文1⃣</label><br>';
print '<p>';
print $menu[$sushi_1];
print $number_1;
print '皿</p></div>';
print '----------------------------------------';
}else{
}
if ($number_2 != "" && $sushi_2 !=""){
print '<input type="hidden" name="sushi_2" value="';
print $menu[$sushi_2];
print '">';
print '<input type="hidden" name="number_2" value="';
print $number_2;
print '">';
print '<div><label>注文2⃣</label><br>';
print '<p>';
print $menu[$sushi_2];
print $number_2;
print '皿</p></div>';
print '----------------------------------------';
}else{
}
if ($number_3 != "" && $sushi_3 !=""){
print '<input type="hidden" name="sushi_3" value="';
print $menu[$sushi_3];
print '">';
print '<input type="hidden" name="number_3" value="';
print $number_3;
print '">';
print '<div><label>注文3⃣</label><br>';
print '<p>';
print $menu[$sushi_3];
print $number_3;
print '皿</p></div>';
print '----------------------------------------';
}else{
}
print '</div>';
print '<button type="button" class="flat-button" onclick="history.back(-1)"><a>変更する</a></button>
  <button type="submit" name="submit" class = "confirm-button">注文確定</button>
  </form>
</div>
</body>
</html>';
}else{
  print "<p>注文内容に不備があります。<br>";
  print "お手数をおかけしますが、再度ご注文をお願いいたします。</p>";
  print '<br><button type="button" class="flat-button" onclick="history.back(-1)"><a>注文画面</a></button>
    </form>
  </div>
  </body>
  </html>';
}



?>
