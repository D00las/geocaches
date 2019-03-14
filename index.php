<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Geokätköt</title>
    
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
    <link href="css/styles.css" rel="stylesheet">
</head>
<body>
    <div class="hull container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <a class="navbar-brand" href="#">Kätköt</a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
              <li class="nav-item active">
                <a class="nav-link" href="#">Etusivu</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="form.php">Lisää kätkö<span class="sr-only">(current)</span></a>
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
        <div class="board card">
            <div class="card-body">
                <span>PLACEHOLDER</span>
            </div>
        </div>
    </div>
</body>
</html>