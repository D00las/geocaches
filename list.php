<?php
require_once "cachePDO.php";

if (isset ( $_POST ["show"] )) {
    session_start();
    $_SESSION["id"] = $_POST["id"];
    header("location: show.php");
}    
if (isset ( $_POST ["delete"] )) {
    $id = $_POST["id"];
    $handleDB = new cachePDO();
    $rows = $handleDB -> deleteCache($id);
    header("Refresh:0");
}
//if (isset ( $_POST ["search"] )) {
//    $search = $_POST["searchFor"];
//    
//}
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
              <li class="nav-item">
                <a class="nav-link" href="form.php">Lisää kätkö</a>
              </li>
              <li class="nav-item active">
                <a class="nav-link" href="#">Kätköt <span class="sr-only">(current)</span></a>
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
            <table class="table-striped">
                <tr>
                    <th>Tunnus</th>
                    <th>Kätkön nimi</th>
                    <th>Vaikeus</th>
                    <th>Sijainti</th>
                </tr>
                <?php 
                    try {
                        $handleDB = new cachePDO();
                        $rows = $handleDB -> listAll();
                        
                        foreach ( $rows as $cache ) {
                            print ("<tr><td>" . $cache->getId() . "</td>");
                            print ("<td>" . $cache->getName(). "</td>");
                            
                            if ($cache -> getTerrain() == "easy") {
                                print("<td>Helppo maastoinen</td>");
                            } else if ($cache -> getTerrain() == "medium") {
                                print("<td>Keskivaikea maasto</td>");
                            } else {
                                print("<td>Vaikea maastoinen</td>");
                            }
                            
                            print ("<td>" . $cache->getCoordinates() . "</td>");
                            print (
                            "<td>
                                <form action='' method='post'>
                                    <input type='hidden' name='id' value='" . $cache->getId() . "'>
                                    <button type='submit' class='btn btn-success' name='show'>Näytä</button>
                                    <button type='submit' class='btn btn-danger' name='delete'>Poista</button>
                                </form>
                            </td>
                            </tr>"
                            );
                        }
                    } catch ( Exception $error ) {
                        print( $error->getMessage());
                        exit ();
                    }
                ?>
            </table>
<!--
            <br>
            <form action="" method="post">
                <label>Etsi maaston vaikeuden mukaan</label>
                <select name="searchFor">
                    <option value="easy">Helppo</option>
                    <option value="medium">Keskivaikea</option>
                    <option value="hard">Vaikea</option>
                </select>
                <button type="submit" name="search" class="btn btn-success">Etsi</button>
                <div name="results"></div>
            </form>
-->
        </div>
    </div>
</body>
</html>