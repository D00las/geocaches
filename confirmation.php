<?php
require_once "cache.php";
session_start();

if (isset( $_SESSION["cache"])) {
    $cache = $_SESSION["cache"];
} else {
    header ("location: index.php");
    exit();
}

if (isset ( $_POST ["delete"] )) {
    unset($_SESSION["cache"]);
	header ( "location: index.php" );
	exit ();
} 
if (isset ( $_POST ["edit"] )) {
	header ( "location: form.php" );
	exit ();
} 

if (isset ( $_POST ["save"] )) {
    require_once "cachePDO.php";
    $newCache = $_SESSION["cache"];
    $db = new cachePDO();
    $results = $db -> addCache($newCache);
        
    unset($_SESSION["cache"]);
	print(
        "<span>Tiedot tallennettu!</span><br>
        <a href='list.php')>Näytä kaikki kätköt</a>"
    );
	exit ();
}
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
            <h2>Tarkista antamasi tiedot</h2>
            <br>
            <?php 
                print(
                    "<h3>" . $cache -> getName() . "</h3>
                    <div class='imageHolder'>
                    <img src=" . $cache -> getPicture() . " alt=" . $cache -> getPicture() . " class=\"image\"><br><br>
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
                    "<p>Lisätiedot: " . $cache -> getDescription() . "</p>\n"
                ); 
            ?>
            <form action="confirmation.php" method="post">
                <button type="submit" class="btn btn-primary confirmation" name="edit">Muokkaa</button>
                <button type="submit" class="btn btn-success confirmation" name="save">Tallenna</button>
                <button type="submit" class="btn btn-danger confirmation" name="delete">Poista</button>
            </form>
        </div>
    </div>
</body>
</html>