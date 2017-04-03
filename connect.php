<?php
$config['db'] = array(
		'host'      => 'localhost:3306',
		'username'  => 'root',
		'password'  => '#sim@sql#',
		'dbname'    => 'elysium'
);
	try {
		//$pdo = new PDO('mysql:host=localhost:3306;dbname=elysium;', 'root', '#sim@sql#');
		$db = new PDO('mysql:host=' .$config['db']['host']. ';dbname=' .$config['db']['dbname'], $config['db']['username'], $config['db']['password']);
		$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		$db->exec("SET CHARACTER SET utf8");
	}
	catch (PDOException $err) {
		echo "Access Denied";
		$err->getMessage() . "<br/>";
		//error olursa diag icin log tut
		file_put_contents('ErrorLogPDO.txt',$err, FILE_APPEND);
	}
?>
