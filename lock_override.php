<!DOCTYPE html>
<html>
<head>
<style>
.error {
	color: #FF0000;
}
</style>
</head>
<body>
<?php
require 'database.class.php';

$config = parse_ini_file ( 'config.ini' );

define ( "DB_HOST", $config ['DB_HOST'] );
define ( "DB_USER", $config ['DB_USER'] );
define ( "DB_PASS", $config ['DB_PASS'] );
define ( "DB_NAME", $config ['DB_NAME'] );

$database = new Database ();

if (isset ( $_POST ['formSubmit'] )) {
	$permit = $_POST ['formDisableTime'];
	$errorMessage = "";

	if (empty ( $permit )) {
		$errorMessage = "<li>Lütfen bir zaman dilimi seçiniz.</li>";
	}

	if ($errorMessage != "") {
		echo ("<p>Bir sorun oluştu:</p>\n");
		echo ("<ul>" . $errorMessage . "</ul>\n");
	}
	else
	{

		$database->query('TRUNCATE table entries');
		$database->execute();

		$expiry = time()+$permit;

		$database->query ( 'INSERT INTO entries(permit)VALUES(:permit)' );
		$database->bind ( ':permit', $expiry );
		$database->execute ();

		$permission = array ();

		array_push ( $permission, $expiry );
		file_put_contents ( 'Permissions.txt', '' );
		file_put_contents ( 'Permissions.txt', serialize ( $permission ) );
	}
}


?>
<h2>Kart Kontrolünü Devre Dışı Bırak</h2>
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"
		method="post">
		<select name="formDisableTime">
			<option value="">Seçiniz...</option>
			<option value="900">15 Dakika</option>
			<option value="1800">30 Dakika</option>
			<option value="3600">1 Saat</option>
			<option value="7400">2 Saat</option>
			<option value="14800">4 Saat</option>
			<option value="29600">8 Saat</option>
			<option value="43200">12 Saat</option>
			<option value="86400">24 Saat</option>
		</select> <input type="submit" name="formSubmit" value="Onayla" />
	</form>
	<br>
	<h2>Mevcut Giriş Kuralları</h2>
	 <table id="permission-table">
            <tr style="font-weight:bold;">
                <td>ID</td>
                <td>Card ID</td>
                <td>Date</td>
                <td>Permit</td>
            </tr>
            <?php
            $database->query ( "SELECT id, card_id, date, permit FROM entries" );
            $database->execute();
            while ($r = $database->fetchSingle ()) {
                $date = date('d-m-y H:m:s',$r['permit']);
            	echo "<tr>";
                echo "<td>".$r['id']."</td>";
                echo "<td>".$r['card_id']."</td>";
                echo "<td>".$r['date']."</td>";
                echo "<td>".$date."</td>";
                echo "</tr>";
               }

            ?>
            </table>
            <br>
<?php
  if (!empty($_POST['act']))
  {
    $database->query('TRUNCATE table entries');
    $database->execute();
    file_put_contents ( 'Permissions.txt', '' );

  }
  else
  {
?>
<form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?> method="post">
  <input type="Submit" name="act" value="Bütün İzinleri Kaldır">
</form>
<?php
  }
?>
</body>
</html>
