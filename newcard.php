<!DOCTYPE html>
<html>
<head>
<style>
.error {color: #FF0000;}
</style>    
</head>
<body>
<?php 
require 'connect.php';

// degiskenleri tanimliyorum
//$cid = $_GET["cardnr"];

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
	
//XSS, injection vs.ye karsi "temizleyici fonksiyon"
  function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
  }
 
 //Form methodu olusturma
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["name"])) {
    $cnameErr = "isim bos birakilamaz.";
  } else {
    $cname = test_input($_POST["name"]);
  }
  if (empty($_POST["surname"])) {
    $csurnameErr = "Bos birakilamaz";
  } else {
    $csurname = test_input($_POST["surname"]);
  }
  if (!isset($_POST["card_id"])) {
    $cidErr = "Lutfen karti okutunuz.";
  } else {
    $cid = test_input($_POST["card_id"]);
	
	//Karti DB'ye ekliyoruz
	 $stmt = $db->prepare("INSERT INTO cards(name,surname,id)VALUES(:name,:surname,:id)");
	 $stmt->execute(array(':name' => $cname, ':surname' => $csurname, ':id' =>$cid));
	
	//Caching
	 $stmt = $db->prepare("SELECT id FROM cards");
	 $stmt->execute();
	 while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
	 	$id = $row['id'];
	 	array_push($cache, $id);
	 }
	 file_put_contents('Cache.txt', serialize($cache)); 		 		 
	 resetVars();
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
