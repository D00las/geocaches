<?php
require_once "cachePDO.php";
session_start();

if (isset( $_SESSION["id"])) {
    $id = $_SESSION["id"];
    $handleDB = new cachePDO();
    $rows = $handleDB -> searchForCache($id);
} else {
    header ("location: list.php");
    exit();
}

unset($_SESSION["id"]);

?>
<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <title>Lisää kätkö</title>

    <script src="js/bootstrap.min.js"></script>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
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
              <li class="nav-item">
                <a class="nav-link" href="form.php">Lisää kätkö</a>
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
        </nav>
        <div class="board container">
            <?php 
                foreach ( $rows as $cache ) {
                    print(
                        "<h2>" . $cache -> getName() . "</h2>
                        <div class='imageHolder'>
                        <img src='" . $cache -> getPicture() . "' alt='Ei esitettävää kuvaa' class='image'><br><br>
                        </div>
                        <p>Lisännyt: " . $cache -> getAdder() . "</p>
                        <p>Yhteydenoton osoite: " . $cache -> getEmail() . "</p>
                        <p>Koordinaatit: " . $cache -> getCoordinates() . "</p>"
                    );
                    if ($cache -> getTerrain() == "easy") {
                        print("<p>Helppo maastoinen</p>");
                    } else if ($cache -> getTerrain() == "medium") {
                        print("<p>Keskivaikea maasto</p>");
                    } else {
                        print("<p>Vaikea maastoinen</p>");
                    }
                    print(
                        "<p>Lisätiedot: " . $cache -> getDescription() . "</p>
                        <p>Kätkön tunnus: " . $cache -> getId() . "</p>"
                    ); 
                };
            ?>
        </div>
        <a type="submit" class="btn btn-success" href="list.php">Palaa</a>
    </div>
</body>
</html>