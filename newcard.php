<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/HTML; charset=utf-8" />
<style>
.error {color: #FF0000;}
</style>    
</head>
<body>
<?php 
require 'database.class.php';

$config = parse_ini_file('config.ini');

define("DB_HOST", $config['DB_HOST']);
define("DB_USER", $config['DB_USER']);
define("DB_PASS", $config['DB_PASS']);
define("DB_NAME", $config['DB_NAME']);

// degiskenleri tanimliyorum
//$cid = $_GET["cardnr"];

$database = new Database();

$cid= $cname = $csurname = "";
$cidErr = $cnameErr = $csurnameErr = "";

function resetVars(){
$cid= $cname = $csurname = "";
$cidErr = $cnameErr = $csurnameErr = "";
}

//Sayfayi temizliyorum herseye karsi
resetVars();

//Cache array olusumu
$cache= array();
	

 //Form methodu olusturma
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["name"])) {
    $cnameErr = "isim bos birakilamaz.";
  } else {
    $cname = cleanInput($_POST["name"]);
  }
  if (empty($_POST["surname"])) {
    $csurnameErr = "Bos birakilamaz";
  } else {
    $csurname = cleanInput($_POST["surname"]);
  }
  if (!isset($_POST["card_id"])) {
    $cidErr = "Lutfen karti okutunuz.";
  } else {
    $cid = cleanInput($_POST["card_id"]);
	
	//Karti DB'ye ekliyoruz
	
    $database->query('INSERT INTO cards(name,surname,card_id)VALUES(:name,:surname,:card_id)');
	$database->bind(':name', $cname);
	$database->bind(':surname',$csurname);
	$database->bind(':card_id', $cid);
	$database->execute();
	
	//Caching
	 $database->query("SELECT card_id FROM cards");
	 $database->execute();
	 while($row = $database->fetchSingle()){
	 	$id = $row['card_id'];
	 	array_push($cache, $id);
	 }
	 file_put_contents('Cache.txt', '');
	 file_put_contents('Cache.txt', serialize($cache)); 		 		 	
 }
}

 //Eklenen kartin bilgilerini teyit ediyoruz, daha sonra daha sofistike bir kod yazilabilir
    echo "<h2>Eklenen kart bilgileri:</h2>";
    echo $cname;
    echo "<br>";
    echo $csurname;
    echo "<br>";
    echo $cid;
    echo "<br>"; 
    
    //resetVars();
 ?>
<h2>Yeni Kart Sihirbazi</h2>
<p><span class="error">Hic bir alani bos birakmayiniz.</span></p>
<?php echo implode("</br>", $cache) ?>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
 isim: <input type="text" name="name">
  <span class="error"><?php echo $cnameErr;?></span>
  <br><br>
  Soyisim: <input type="text" name="surname">
  <span class="error"><?php echo $csurnameErr?></span>
  <br><br>
  Kart ID: <input type="text" name="card_id" value=<?php echo $cid;?>>
  <span class="error"><?php echo $cidErr;?></span>
  <br><br>
  <input type="submit" name="submit" value="Submit"></input>
</form>  
</body>
</html>