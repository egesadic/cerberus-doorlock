<!DOCTYPE html>
<html>
<body>
<?php
require 'connect.php';

//$card = $_GET["cardnr"];
$card= '1TS45M';

//DB'den ID kar��la�t�rmas�n�n yap�ld��� query
$stmt = $db->prepare("SELECT * FROM cards WHERE id = ?");
$stmt->bindParam(1,$card);
$stmt->execute();

while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
	$id = htmlentities($row['id']);
}

//idler uyu�ur ise return #1 veya #0 burdan d�nd�r�lecek.
	if($card == $id)
		echo'#1';
	else echo '#0';
?>
</body>
</html>
