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

$id = $_SESSION['id'] ?? false;
$name = 'Not Logged In';
if ($id) {

    date_default_timezone_set('America/New_York');

    $host = 'localhost';
    $db = 'yore';
    $user = 'heidi';
    $pass = 'Mermaid7!!';
    $port = "3306";
    $charset = 'utf8mb4';

    $options = [
        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        \PDO::ATTR_EMULATE_PREPARES => false,
    ];
    $dsn = "mysql:host=$host;dbname=$db;charset=$charset;port=$port";
    try {
        $pdo = new \PDO($dsn, $user, $pass, $options);
    } catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }

    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $r = $stmt->execute([ $id ]);
    $rows = $stmt->fetchAll();

    if ($rows) {
        $row = $rows[0];
        $id = $row['id'];
        $name = $row['name'];

    }

}



if ($id) {

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
<nav class="navbar navbar-expand-md xnavbar-dark xbg-dark fixed-top">
    <a class="navbar-brand" href="#">Twilite</a>
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
                <a class="save nav-link disabled" href="#">Save</a>
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
    <div class="topside">Super Easy * Barely an Inconvenience</div>
    <div class="leftside"></div>
    <div class="rightside"><pre contentEditable="true" id="code"></pre></div>
    <div style="clear:both"></div>
    <div class="bottomside">Output</div>

</div>

<!-- Only load this Js if the user is logged in -->
<script defer="defer"  type="application/javascript" src="javascript.js" /></script>

<?php

} // if $id

else // if not logged in

{
?>

<!--
 ######   #######  ##     ## ######## ########     ########     ###     ######   ########
##    ## ##     ## ##     ## ##       ##     ##    ##     ##   ## ##   ##    ##  ##
##       ##     ## ##     ## ##       ##     ##    ##     ##  ##   ##  ##        ##
##       ##     ## ##     ## ######   ########     ########  ##     ## ##   #### ######
##       ##     ##  ##   ##  ##       ##   ##      ##        ######### ##    ##  ##
##    ## ##     ##   ## ##   ##       ##    ##     ##        ##     ## ##    ##  ##
 ######   #######     ###    ######## ##     ##    ##        ##     ##  ######   ########
-->

    <nav class="navbar navbar-expand-md xnavbar-dark xbg-dark fixed-top">
        <a class="navbar-brand" href="#">Twilite</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Onsie</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Twosie</a>
                </li>
            </ul>
<!--            <h4><i class="bi bi-heart theme-navbar-color"></i></h4>-->
            <button class="btn btn-outline-warning my-2 my-sm-0 joinbutton" type="submit">Join</button>
            &nbsp
            <button class="btn btn-outline-success my-2 my-sm-0 loginbutton" type="submit">Login</button>
        </div>
    </nav>


    <main role="main" class="container">

        <div class="starter-template front-page">
            <h1>Twilite BASIC IVR Scripting</h1>
            <p class="lead">Create full-featured Twilio® voice and messaging apps
                <br/>All you need is a Twilio account and Twilio phone number
                <br/>Twilite is a simple BASIC-like language you can lean in minutes
                <br/>
            </p>
        </div>

        <div class="starter-template register-part" style="display:none;">

            <h1>Register</h1>
            <center>
            <div class="register">
                <form autocomplete="off" method="post">
                <input type="hidden" name="action" value="register">
                <table>
                    <tr>
                        <td>Name&nbsp;&nbsp;&nbsp;</td>
                        <td><input autocomplete="false" type="text" name="name" id="name"></td>
                    </tr>
                    <tr>
                        <td>Email&nbsp;&nbsp;&nbsp;</td>
                        <td><input autocomplete="none" type="email" name="email" id="email"></td>
                    </tr>
                    <tr>
                        <td>Password&nbsp;&nbsp;&nbsp;</td>
                        <td><input autocomplete="false" type="password" name="password" id="password"></td>
                    </tr>
                    <tr>
                        <td>Password Again&nbsp;&nbsp;&nbsp;</td>
                        <td><input autocomplete="false" type="password" name="password2" id="password2"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" value="Register" class="btn btn-primary"></td>
                    </tr>
                </table>
                </form>
            </div>
            </center>
        </div>

        <div class="starter-template login-part" style="display:none;">

            <h1>Login</h1>
            <center>
                <div class="login">
                    <form autocomplete="off" method="post">
                        <input type="hidden" name="action" value="login">
                        <table>
                            <tr>
                                <td>Email&nbsp;&nbsp;&nbsp;</td>
                                <td><input autocomplete="none" type="email" name="email" id="email"></td>
                            </tr>
                            <tr>
                                <td>Password&nbsp;&nbsp;&nbsp;</td>
                                <td><input autocomplete="false" type="password" name="password" id="password"></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><input type="submit" value="Login" class="btn btn-primary"></td>
                            </tr>
                        </table>
                    </form>
                </div>
            </center>
        </div>



    </main><!-- /.container -->

<!-- Only load this Js if the user is NOT logged in -->
<script defer="defer"  type="application/javascript" src="cover.js" /></script>


    <?php
}

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

<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://getbootstrap.com/docs/4.0/assets/js/vendor/popper.min.js"></script>
<script src="https://getbootstrap.com/docs/4.0/dist/js/bootstrap.min.js"></script>
<center style="font-size:xx-small;">Twilio is a registered trademark of Twilio Inc. and/or its affiliates. Other names may be trademarks of their respective owners</center>
</body>
</html>
