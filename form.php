<?php
require_once "cache.php";
session_start();

if (isset ( $_POST ["submit"] )) {
    $cache = new Cache($_POST["adder"],
                       $_POST["email"],
                       $_POST["name"],
                       $_POST["picture"],
                       $_POST["coordinates"],
                       $_POST["terrain"],
                       $_POST["description"]);
                       
    $_SESSION["cache"] = $cache;
    session_write_close();
    
    $adderError = $cache->checkAdder();
    $emailError = $cache->checkEmail();
    $nameError = $cache->checkName();
    $pictureError = $cache->checkPicture();
    $coordinatesError = $cache->checkCoordinates();
    $terrainError = $cache->checkTerrain();
    $descriptionError = $cache->checkDescription();
    
    if (
        $adderError == 0 &&
        $emailError == 0 &&
        $nameError == 0 &&
        $pictureError == 0 &&
        $coordinatesError == 0 &&
        $terrainError == 0 &&
        $descriptionError == 0
    ) {
        header("location: confirmation.php");
        exit();
    }
    
} else if (isset ( $_POST ["cancel"] )) {
    unset($_SESSION["cache"]);
	header ( "location: index.php" );
	exit ();
} else {
    if (isset($_SESSION["cache"])) {
        $cache = $_SESSION["cache"];
        $adderError = $cache -> checkAdder();
        $emailError = $cache -> checkEmail();
        $nameError = $cache -> checkName();
        $pictureError = $cache -> checkPicture();
        $coordinatesError = $cache -> checkCoordinates();
        $terrainError = $cache -> checkTerrain();
        $descriptionError = $cache -> checkDescription();
    } else {
        $cache = new Cache();
        $adderError = 0;
        $emailError = 0;
        $nameError = 0;
        $pictureError = 0;
        $coordinatesError = 0;
        $terrainError = 0;
        $descriptionError = 0;
    }
}
?>
<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <title>Lisää kätkö</title>

    <script src="js/bootstrap.min.js"></script>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="styles.css" rel="stylesheet">
</head>
<body>
    <div class="hull container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <a class="navbar-brand" href="index.php">Kätköt</a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
              <li class="nav-item">
                <a class="nav-link" href="index.php">Etusivu</a>
              </li>
              <li class="nav-item active">
                <a class="nav-link" href="#">Lisää kätkö <span class="sr-only">(current)</span></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="list.php">Kätköt</a>
              </li>
                <li class="nav-item">
                <a class="nav-link" href="settings.php">Asetukset</a>
              </li>
            </ul>
            <div class="usernameHolder">
                <?php 
                    if (isset($_COOKIE["username"])) {
                        print("<span>" . $_COOKIE["username"] . "</span>"); 
                    } else {
                        print("<span>Et ole kirjautunut sisään</span>");
                    }
                ?>
            </div>
          </div>
          </div>
        </nav>
        <div class="board container">
            <form class="form-horizontal" action="form.php" method="post">
                <div class="form-group row">
                    <label class="control-label col-sm-2" for="adder">Nimimerkki</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="adder" name="adder" placeholder="Nimimerkki" 
                               value="<?php print(htmlentities($cache->getAdder(), ENT_QUOTES, 'UTF-8'))?>">
                        <?php print("<span class='error'>" . $cache->getError($adderError) . "</span>")?>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="control-label col-sm-2" for="email">Email</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="email" name="email" placeholder="Email" 
                               value="<?php print(htmlentities($cache->getEmail(), ENT_QUOTES, 'UTF-8'))?>">
                        <?php print("<span class='error'>" . $cache->getError($emailError) . "</span>")?>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="control-label col-sm-2" for="name">Kätkön nimi</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nimi" 
                               value="<?php print(htmlentities($cache->getName(), ENT_QUOTES, 'UTF-8'))?>">
                        <?php print("<span class='error'>" . $cache->getError($nameError) . "</span>")?>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="control-label col-sm-2" for="picture">Kuva</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="picture" name="picture" placeholder="URL" 
                               value="<?php print(htmlentities($cache->getPicture(), ENT_QUOTES, 'UTF-8'))?>">
                        <?php print("<span class='error'>" . $cache->getError($pictureError) . "</span>")?>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="control-label col-sm-2" for="coordinates">Sijainti</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="coordinates" name="coordinates" placeholder="Koordinaatit" 
                               value="<?php print(htmlentities($cache->getCoordinates(), ENT_QUOTES, 'UTF-8'))?>">
                        <?php print("<span class='error'>" . $cache->getError($coordinatesError) . "</span>")?>
                    </div>
                    <span class="col-sm-2 tip">Muodossa:<br>60.201485, 24.934020</span>
                </div>
                <div class="form-group row">
                    <label class="control-label col-sm-2" for="terrain">Maasto</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="terrain" id="terrain">
                            <option value="" disabled <?php if ($cache->getTerrain() == '') { ?>selected="selected" <?php }; ?>>Maasto</option>
                            <option value="easy" <?php if ($cache->getTerrain() == 'easy') { ?>selected="selected" <?php }; ?>>Helppo</option>
                            <option value="medium" <?php if ($cache->getTerrain() == 'medium') { ?>selected="selected" <?php }; ?>>Kohtalainen</option>
                            <option value="hard" <?php if ($cache->getTerrain() == 'hard') { ?>selected="selected" <?php }; ?>>Vaikea</option>
                        </select>
                        <?php print("<span class='error'>" . $cache->getError($terrainError) . "</span>")?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label" for="description">Kätkön kuvaus</label>
                    <textarea class="form-control" id="description" name="description" placeholder="Kuvaus"><?php print(htmlentities($cache->getDescription(), ENT_QUOTES, 'UTF-8'))?></textarea>
                    <?php print("<span class='error'>" . $cache->getError($descriptionError) . "</span>")?>
                </div>
                <button type="submit" name="submit" class="btn btn-success">Lisää</button>
                <button type="submit" name="cancel" class="btn btn-danger">Peruuta</button>
            </form>
        </div>
    </div>
</body>
</html>