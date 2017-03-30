<!DOCTYPE html>
<html>
<head>
<style>
.error {color: #FF0000;}
</style>    
</head>
<body>
<?php
//Database'e baglanti.
try {
    $pdo = new PDO('mysql:host=localhost:3306;dbname=elysium;charset=utf8mb4', 'root', '#sim@sql#'); 
    $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    $pdo->exec("SET CHARACTER SET utf8");
}
catch (PDOException $err) {  
            echo "Access Denied";
            $err->getMessage() . "<br/>";
            //error olursa diag icin log tut
            file_put_contents('ErrorLogPDO.txt',$err, FILE_APPEND);  
  //Baglantiyi test ediyorum, sonra silinecek.
echo "Connected to MySQL<br>";

// degiskenleri tanimliyorum
$cid = $cname = $csurname = "";
$cidErr = $cnameErr = $csurnameErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["name"])) {
    $cnameErr = "İsim bos birakilamaz.";
  } else {
    $cname = test_input($_POST["name"]);
  }
  if (empty($_POST["surname"])) {
    $csurnameErr = "Bos birakilamaz";
  } else {
    $csurname = test_input($_POST["surname"]);
  }
  if (empty($_POST["card_id"])) {
    $cidErr = "Lutfen karti okutunuz.";
  } else {
    $cid = test_input($_POST["card_id"]);
  }
  
  //XSS, injection vs.ye karsi "temizleyici fonksiyon"
  function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;

 //Karti DB'ye ekliyoruz
 $stmt = $db->prepare("INSERT INTO cards(name,surname,card_id) VALUES(:name,:surname,:card_id)");
 $stmt->execute(array(':field1' => $cname, ':field2' => $csurname, ':field3' => $cid));
 $affected_rows = $stmt->rowCount();
 
 //Eklenen kartin bilgilerini teyit ediyoruz
    echo "<h2>Eklenen kart bilgileri:</h2>";
    echo $cname;
    echo "<br>";
    echo $csurname;
    echo "<br>";
    echo $cid;
    echo "<br>";
    //Cachingle ilgili calismalari da herhalde cumaya kadar koyarım. Bu arada konuyla ilgili arastirmami yapıyor olacagim
?>        
<h2>Yeni Kart Sihirbazı</h2>
<p><span class="error">Hiç bir alanı boş bırakmayınız.</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
  İsim: <input type="text" name="name">
  <span class="error"><?php echo $cnameErr;?></span>
  <br><br>
  Soyisim: <input type="text" name="email">
  <span class="error"><?php echo $csurnameErr?></span>
  <br><br>
  Kart ID: <input type="text" name="website">
  <span class="error"><?php echo $cidErr;?></span>
  <br><br>
  <input type="submit" name="submit" value="Submit">
</form>  
</body>
</html>