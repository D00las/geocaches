<?php
class Cache {
    private static $errorList = array (
        -1 => "Tuntematon virhe",
        0 => "",
        // 00. Yleiset
        1 => "Tiedossa kielettyjä merkkejä",
        2 => "Vaadittava tieto",
        3 => "Tieto liian lyhyt",
        4 => "Tieto liian pitkä",
        // 10. Nimimerkki
        
        // 20. Sähköposti
        21 => "Tarkista sähköpostin muoto",
        
        // 30. Kätkön nimi
        
        // 40. Kuva, URL
        41 => "Tarkista URL:n muoto",
        
        // 50. Sijainti, koordinaatit
        51 => "Tarkista koordinaatin muoto",
        
        // 60. Maasto & esteellisyys
        61 => "Valitse jokin vaihtoehto",
        62 => "Tieto ei vastaa mitään annetuista vaihtoehdoista!",
        // 70. Kätkön kuvaus
        
    );
    
    public static function getError($errorKey) {
        if (isset ( self::$errorList [$errorKey] ))
            return self::$errorList [$errorKey];
        
        return self::$errorList [-1];
    } 
    
    private $adder;
    private $email;
    private $name;
    private $picture;
    private $coordinates;
    private $terrain;
    private $description;
    private $id;
    
    function __construct(
        $adder = "",
        $email = "",
        $name = "",
        $picture = "",
        $coordinates = "",
        $terrain = "",
        $description = "",
        $id = 0
    ) {
        $this->adder = trim (mb_convert_case($adder, MB_CASE_TITLE, "UTF-8"));
        $this->email = trim (mb_convert_case($email, MB_CASE_LOWER, "UTF-8"));        
        $this->name = trim (mb_convert_case($name, MB_CASE_TITLE, "UTF-8"));
        $this->picture = trim (mb_convert_case($picture, MB_CASE_LOWER, "UTF-8"));
        $this->coordinates = trim ($coordinates);
        $this->terrain = trim ($terrain);
        $this->description = trim (ucfirst($description));
        $this->id = $id;
    }
    // Kirjaaja
    public function setAdder($adder) {
        $this->adder = trim($adder);
    }
    public function getAdder() {
        return $this->adder;
    }
    public function checkAdder($required = true, $min = 2, $max = 25) {
		if ($required == true && strlen($this->adder) == 0) {
			return 2;
		}
		if (preg_match("/[^a-zåäöA-ZÅÄÖ0-9\-\&\_\s]/", $this->adder)) {
			return 21;
		}
		if (strlen($this->adder) < $min) {
			return 3;
		}
		if (strlen($this->adder) > $max) {
			return 4;
		}
		return 0;
	}
    // Email
    public function setEmail($email) {
        $this->email = trim($email);
    }
    public function getEmail() {
        return $this->email;
    }
    public function checkEmail($required = true, $max = 50) {
		if ($required == true && strlen($this->email) == 0) {
			return 2;
		}
		if (preg_match("/[åäö\"\'\<\>\[\]\´\`\{\}\^\¨\*\,\;\|\s]/", $this->email)) {

            return 1;
		}
        if (!preg_match("/^[a-z0-9\-\_]+(\.[a-z0-9\-\_]+)*@[a-z0-9\-\_]+(\.[a-z0-9\-\_]+)*(\.[a-z]{2,3})$/", $this->email)) {

            return 21;
		}
        if (preg_match("/\.\./", $this->picture)) {
			return 21;
		}
		if (strlen($this->email ) > $max) {
			return 4;
		}
		return 0;
	}
    // Kätkön nimi
    public function setName($name) {
        $this->name = trim($name);
    }
    public function getName() {
        return $this->name;
    }
    public function checkName($required = true, $min = 2, $max = 50) {
		if ($required == true && strlen($this->name) == 0) {
			return 2;
		}
		if (preg_match ("/[^a-zåäöA-ZÅÄÖ0-9\-\&\_\s]/", $this->name)) {
			return 1;
		}
		if (strlen($this->name) < $min) {
			return 3;
		}
		if (strlen($this->name) > $max) {
			return 4;
		}
		return 0;
	}
    // Kuva, URL
    public function setPicture($picture) {
        $this->picture = trim($picture);
    }
    public function getPicture() {
        return $this->picture;
    }
    public function checkPicture($required = false, $max = 225) {
		if ($required == false && strlen($this->picture) == 0) {
			return 0;
		}
		if (preg_match("/[åäö\"\'\<\>\[\]\´\`\{\}\(\)\^\¨\*\,\;\|\s]/", $this->picture)) {

            return 1;
		}
		if (!preg_match("/^(https\:\/\/)+([^åäö\"\'\<\>\[\]\´\`\{\}\(\)\^\¨\*\,\;\|\s])+(\.[^åäö\"\'\<\>\[\]\´\`\{\}\(\)\^\¨\*\,\;\|\s])+(\.[^åäö\"\'\<\>\[\]\´\`\{\}\(\)\^\¨\*\,\;\|\s])*/", $this->picture)) {
            // Väärä muoto
			return 41;
		}
        if (preg_match("/\.\./", $this->picture)) {
            // Väärä muoto
			return 41;
		}
		if (strlen($this->picture) > $max) {
			return 4;
		}
		return 0;
	}
    // Sijainti, koordinaatit
    public function setCoordinates($coordinates) {
        $this->coordinates = trim($coordinates);
    }
    public function getCoordinates() {
        return $this->coordinates;
    }
    public function checkCoordinates($required = true, $min = 19, $max = 21) {
		if ($required == true && strlen($this->coordinates) == 0) {
			return 2;
		}
		if (!preg_match("/\d{2}\.\d{6}\,\s\d{2}\.\d{6}/", $this->coordinates )) {
			return 51;
		}
		if (strlen($this->coordinates) < $min) {
			return 3;
		}
		if (strlen($this->coordinates) > $max) {
			return 4;
		}
		return 0;
	}
    // Maasto
    public function setTerrain($terrain) {
        $this->terrain = trim($terrain);
    }
    public function getTerrain() {
        return $this->terrain;
    }
    public function checkTerrain($required = true) {
		if ($required == true && strlen($this -> terrain) == 0) {
			return 61;
		}
        if (!preg_match("/easy|medium|hard/", $this->terrain )) {
			return 62;
        }
		return 0;
	}
    // Kuvaus
    public function setDescription($description) {
        $this->description = trim($description);
    }
    public function getDescription() {
        return $this->description;
    }
    public function checkDescription($required = false, $max = 225) {
		if ($required == false && strlen($this->description) == 0) {
			return 0;
		}
		if (preg_match("/[^a-zåäöA-ZÅÄÖ\-\(\)0-9\s ]/", $this->description )) {
			return 1;
        }
        if (strlen($this->coordinates) > $max) {
			return 4;
		}
		return 0;
	}
    
    public function setId($id) {
		$this -> id = trim($id);
	}

	public function getId() {
		return $this -> id;
	}
}
?>
