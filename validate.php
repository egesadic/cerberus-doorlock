<!DOCTYPE html>
<html>
<body>
<?php
    //Database'e baðlantý. Kapýda her seferinde DB'ye baðlanýp kilit açýlana kadar bekleme olmasýn diye PERSISTENT ATTR koydum ancak ne kadar 
    //etkisi olur bilemiyorum. 
$pdo = new PDO('mysql:host=localhost:3306;dbname=elysium;charset=utf8mb4', 'root', '#sim@sql#')//,array(PDO::ATTR_PERSISTENT => true) 
  or die("Unable to connect to MySQL");
  //Baðlantýyý test ediyorum, sonra silinecek.
echo "Connected to MySQL<br>";

//$card = $_GET["cardnr"];
$card= '1TS45M';

//DB'den ID karþýlaþtýrmasýnýn yapýldýðý query
$stmt = $pdo->prepare("SELECT * FROM cards WHERE id = ?");
$stmt->bindParam(1,$card);
$stmt->execute();

while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
	$id = htmlentities($row['id']);
}

//idler uyuþur ise return #1 veya #0 burdan döndürülecek.
	if($card == $id)
		echo'#1';
	else echo '#0';

?>
</body>
</html>
