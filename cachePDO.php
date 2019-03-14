<?php
require_once "cache.php";

class cachePDO {

	private $db;
	private $i;

	function __construct( $dsn = "mysql:host=localhost;dbname=a1602665", $user = "root", $password = "salainen" ) {
		$this -> db = new PDO( $dsn, $user, $password );
		$this -> db -> setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
		$this -> db -> setAttribute( PDO::ATTR_EMULATE_PREPARES, false );
		$this -> i = 0;
	}
    
	function getI() {
		return $this -> i;
	}

	public function listAll() {
		$sql = "SELECT * FROM cache";
		if (! $stmt = $this -> db -> prepare( $sql )) {
			$error = $this -> db -> errorInfo();
			throw new PDOException( $error [2], $error [1] );
		}
		if (! $stmt -> execute() ) {
			$error = $stmt -> errorInfo();

			throw new PDOException( $error [2], $error [1] );
		}
		$results = array ();
		while ( $row = $stmt -> fetchObject() ) {
			$cache = new Cache();

			$cache -> setId( $row -> id );
			$cache -> setAdder(utf8_encode( $row -> adder ));
			$cache -> setEmail(utf8_encode( $row -> email ));
			$cache -> setName(utf8_encode( $row -> name ));
			$cache -> setPicture($row -> picture);
			$cache -> setTerrain(utf8_encode( $row -> terrain ));
            $cache -> setCoordinates( $row -> coordinates );
            $cache -> setDescription(utf8_encode( $row -> description ));
            
			$results[] = $cache;
		}

		$this -> i = $stmt -> rowCount();

		return $results;
	}

	public function searchForCache($id) {
		$sql = "SELECT * FROM cache WHERE id = :id";

		if (! $stmt = $this -> db -> prepare( $sql )) {
			$error = $this -> db -> errorInfo ();
			throw new PDOException( $error [2], $error [1] );
		}

		$stmt -> bindValue( ":id", $id, PDO::PARAM_INT );

		if (! $stmt -> execute()) {
			$error = $stmt->errorInfo();

			if ($error[0] == "???") {
				$error[2] = "Invalid parameter";
			}

			throw new PDOException( $error[2], $error[1] );
		}
		$results = array();

		while ( $row = $stmt -> fetchObject() ) {
			$cache = new Cache ();
            
			$cache -> setAdder(utf8_encode( $row -> adder ));
			$cache -> setEmail(utf8_encode( $row -> email ));
			$cache -> setName(utf8_encode( $row -> name ));
			$cache -> setPicture($row -> picture );
            $cache -> setCoordinates( $row -> coordinates );
			$cache -> setTerrain(utf8_encode( $row -> terrain ));
            $cache -> setDescription(utf8_encode( $row -> description ));
            $cache -> setId( $row -> id );
			$results[] = $cache;
		}

		$this -> i = $stmt -> rowCount();

		return $results;
	}

	function addCache($cache) {
		$sql = "INSERT INTO cache (adder, email, name, picture, terrain, coordinates, description) VALUES (:adder, :email, :name, :picture, :terrain, :coordinates, :description)";
        
		if (! $stmt = $this -> db -> prepare( $sql )) {
			$error = $this -> db -> errorInfo();
			throw new PDOException( $error[2], $error[1] );
		}

		$stmt -> bindValue ( ":adder", utf8_decode( $cache -> getAdder() ), PDO::PARAM_STR );
		$stmt -> bindValue ( ":email", $cache -> getEmail(), PDO::PARAM_STR );
		$stmt -> bindValue ( ":name", utf8_decode( $cache -> getName() ), PDO::PARAM_STR );
		$stmt -> bindValue ( ":picture", $cache -> getPicture(), PDO::PARAM_STR );
		$stmt -> bindValue ( ":terrain", utf8_decode( $cache -> getTerrain() ), PDO::PARAM_STR );
        $stmt -> bindValue ( ":coordinates", $cache -> getCoordinates(), PDO::PARAM_STR );
        $stmt -> bindValue ( ":description", utf8_decode( $cache -> getDescription() ), PDO::PARAM_STR );

		$this -> db -> beginTransaction();

		if (! $stmt -> execute()) {
			$error = $stmt->errorInfo ();

			if ($error [0] == "???") {
				$error [2] = "Invalid parameter";
			}
            
			$this -> db -> rollBack();
			
			throw new PDOException ( $error[2], $error[1] );
		}
        
		$id = $this -> db -> lastInsertId();
        $this -> db -> commit();
		return $id;
	}
    
    function deleteCache($id) {
        $sql = "DELETE FROM cache WHERE id = :id";

		if (! $stmt = $this -> db -> prepare( $sql )) {
			$error = $this -> db -> errorInfo ();
			throw new PDOException( $error [2], $error [1] );
		}

		$stmt -> bindValue( ":id", $id, PDO::PARAM_INT );
        
        $this -> db -> beginTransaction();

		if (! $stmt -> execute()) {
			$error = $stmt->errorInfo();

			if ($error[0] == "???") {
				$error[2] = "Invalid parameter";
			}

			throw new PDOException( $error[2], $error[1] );
		}
        
        $id = $this -> db -> lastInsertId();
        $this -> db -> commit();
    }
}
?>