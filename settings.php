<?php
    $username = "";
    
    if (isset ( $_POST["signin"] )) {
        setcookie("username", $_POST["username"], time() + 60*60*24*7);
        header ( "location: index.php" );
	   exit ();
    } else {
        if (isset($_COOKIE["username"])) {
            $username = $_COOKIE["username"];
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
              <li class="nav-item">
                <a class="nav-link" href="form.php">Lisää kätkö</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="list.php">Kätköt</a>
              </li>
                <li class="nav-item active">
                <a class="nav-link" href="#">Asetukset <span class="sr-only">(current)</span></a>
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
            <form action="settings.php" method="post">
                <div class="row">
                    <input type="text" name="username" value=<?php print($username); ?>>
                    <button type="submit" name="signin">Kirjaudu</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>