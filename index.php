<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Default Yore theme">
    <meta name="author" content="Erik Olson">
    <link rel="icon" href="https://getbootstrap.com/docs/4.0/assets/img/favicons/favicon.ico">
    <title>Twilite BASIC IVR Scripting</title>
    <link href="https://getbootstrap.com/docs/4.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
</head>
<body>
<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

date_default_timezone_set('America/New_York');

$host = 'localhost';
$db   = 'yore';
$user = 'heidi';
$pass = 'Mermaid7!!';
$port = "3306";
$charset = 'utf8mb4';

$options = [
    \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
    \PDO::ATTR_EMULATE_PREPARES   => false,
];
$dsn = "mysql:host=$host;dbname=$db;charset=$charset;port=$port";
try {
    $pdo = new \PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

// Now get the BASIC program from the Twilite SQL table

$sql = "SELECT * FROM twilite order by `To`";
$stmt = $pdo->prepare($sql);
$r = $stmt->execute();
$rows = $stmt->fetchAll();
//var_dump($rows);
if ($rows) {
    $row=$rows[0];
    $source = $row['code'];
}



?>

<!--
##    ##    ###    ##     ## ########     ###    ########
###   ##   ## ##   ##     ## ##     ##   ## ##   ##     ##
####  ##  ##   ##  ##     ## ##     ##  ##   ##  ##     ##
## ## ## ##     ## ##     ## ########  ##     ## ########
##  #### #########  ##   ##  ##     ## ######### ##   ##
##   ### ##     ##   ## ##   ##     ## ##     ## ##    ##
##    ## ##     ##    ###    ########  ##     ## ##     ##
-->
<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="/">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Run</a>
            </li>
            <li class="nav-item">
                <a class="nav-link disabled" href="#">Generate</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="http://example.com" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Programs</a>
                <div class="dropdown-menu" aria-labelledby="dropdown01">
                    <a class="dropdown-item" href="#">New Program</a>
                    <?php

                    foreach($rows as $row) {
                        echo "<a onclick=\"doLoad('{$row['id']}')\" class=\"dropdown-item\" href=\"#\">{$row['To']}</a>";
                    }


                    ?>

                </div>
            </li>
        </ul>
        <h4><i class="bi bi-gear theme-navbar-color"></i></h4>
    </div>
</nav>
<!--
########     ###     ######   ########
##     ##   ## ##   ##    ##  ##
##     ##  ##   ##  ##        ##
########  ##     ## ##   #### ######
##        ######### ##    ##  ##
##        ##     ## ##    ##  ##
##        ##     ##  ######   ########
-->

<div class='main'>
    <div class="topside"></div>
    <div class="leftside"></div>
    <div class="rightside"></div>
    <div style="clear:both"></div>
    <div class="bottomside"></div>

</div>


<?php



?>
<!--
########  #######   #######  ######## ######## ########
##       ##     ## ##     ##    ##    ##       ##     ##
##       ##     ## ##     ##    ##    ##       ##     ##
######   ##     ## ##     ##    ##    ######   ########
##       ##     ## ##     ##    ##    ##       ##   ##
##       ##     ## ##     ##    ##    ##       ##    ##
##        #######   #######     ##    ######## ##     ##
-->
<link media="all" rel="stylesheet" href="style.css" />
<script defer="defer"  type="application/javascript" src="javascript.js" /></script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script>window.jQuery || document.write('<script src="https://getbootstrap.com/docs/4.0/assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
<script src="https://getbootstrap.com/docs/4.0/assets/js/vendor/popper.min.js"></script>
<script src="https://getbootstrap.com/docs/4.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
