<?php
require 'connect.php';

//$card = $_GET["cardnr"];
$card= 'asdfqwer';

//DB'den ID karşılaştırmasının yapıldığı query
$stmt = $db->prepare("SELECT * FROM cards WHERE id = ?");
$stmt->bindParam(1,$card);
$stmt->execute();

while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
	$id = htmlentities($row['id']);
}

//idler uyuşur ise return #1 veya #0 burdan döndürülecek.
	if($card == $id)
		echo '#1';
	else 
		echo '#0';
?>
