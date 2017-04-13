<?php
class Database{

	private $host      = DB_HOST;
	private $user      = DB_USER;
	private $pass      = DB_PASS;
	private $dbname    = DB_NAME;

	private $dbh;
	private $error;
	private $stmt;

	public function __construct(){
		// Set DSN
		$dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
		// Set options
		$options = array(
				PDO::ATTR_PERSISTENT    => true,
				PDO::ATTR_ERRMODE       => PDO::ERRMODE_EXCEPTION
		);
		// Create a new PDO instanace
		try{
			$this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
		}
		// Catch any errors
		catch(PDOException $e){
			$this->error = $e->getMessage();
			file_put_contents('ErrorLogPDO.txt',$e, FILE_APPEND);
			echo 'Access Denied';
		}
	}

	public function query($query){
		$this->stmt = $this->dbh->prepare($query);
	}

	public function bind($param, $value, $type = null){
		if (is_null($type)) {
			switch (true) {
				case is_int($value):
					$type = PDO::PARAM_INT;
					break;
				case is_bool($value):
					$type = PDO::PARAM_BOOL;
					break;
				case is_null($value):
					$type = PDO::PARAM_NULL;
					break;
				default:
					$type = PDO::PARAM_STR;
			}
			$this->stmt->bindValue($param, $value, $type);
		}
	}

	public function execute(){
		return $this->stmt->execute();
	}

	public function resultset(){
		$this->execute();
		return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function fetchAll(){
		return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function fetchSingle(){
		return $this->stmt->fetch(PDO::FETCH_ASSOC);
	}

	public function single(){
		$this->execute();
		return $this->stmt->fetch(PDO::FETCH_ASSOC);
	}

	public function rowCount(){
		return $this->stmt->rowCount();
	}

	public function lastInsertId(){
		return $this->dbh->lastInsertId();
	}

	public function beginTransaction(){
		return $this->dbh->beginTransaction();
	}

	public function endTransaction(){
		return $this->dbh->commit();
	}

	public function cancelTransaction(){
		return $this->dbh->rollBack();
	}
}

/* $config['db'] = array(
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
	} */
?>
