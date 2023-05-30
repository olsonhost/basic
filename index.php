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

$msg = false;

if (isset($_SESSION['msg'])) {
    $msg = $_SESSION['msg'];
    unset($_SESSION['msg']);
}

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
        $email = $row['email'];
    }

}



if ($id) {

    $sql = "SELECT * FROM twilite WHERE user_id = ? order by `To`";
    $stmt = $pdo->prepare($sql);
    $r = $stmt->execute([ $id ]);
    $trows = $stmt->fetchAll();

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
    <a class="navbar-brand" href="/">Twilite</a>
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
                <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Programs</a>
                <div class="dropdown-menu" aria-labelledby="dropdown01">
                    <a class="dropdown-item" href="#" onclick="$('.modal-new').show()">New Program</a>
                    <?php

                    foreach($trows as $trow) {
                        echo "<a onclick=\"doLoad('{$trow['id']}')\" class=\"dropdown-item\" href=\"#\">{$trow['To']}</a>";
                    }

                    ?>
                </div>
            </li>
        </ul>
        <h4><i class="bi bi-gear theme-navbar-color"></i></h4>
        <ul class="navbar-nav xmr-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $name; ?></a>
                <div class="dropdown-menu" aria-labelledby="dropdown01">
                    <a class="dropdown-item" href="/api.php?action=logout">Logout</a>
                </div>
            </li>
        </ul>
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
        <a class="navbar-brand" href="/">Twilite</a>
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
                <br/>Super Easy * Barely an Inconvenience
            </p>
        </div>

        <div class="starter-template register-part" style="display:none;">

            <h1>Register</h1>
            <center>
            <div class="register">
                <form autocomplete="off" method="post" action = "/api.php">
                <input type="hidden" name="action" value="register">
                <table>
                    <tr>
                        <td>Your Full Name&nbsp;&nbsp;&nbsp;</td>
                        <td><input autocomplete="false" type="text" name="name" id="reg-name"></td>
                    </tr>
                    <tr>
                        <td>Your Email&nbsp;&nbsp;&nbsp;</td>
                        <td><input autocomplete="none" type="email" name="email" id="reg-email"></td>
                    </tr>
                    <tr>
                        <td>Enter a Password&nbsp;&nbsp;&nbsp;</td>
                        <td><input autocomplete="false" type="password" name="password" id="reg-password" onchange="doPasswordCheck()"></td>
                    </tr>
                    <tr>
                        <td>Enter the Password Again&nbsp;&nbsp;&nbsp;</td>
                        <td><input autocomplete="false" type="password" name="password2" id="reg-password2" onchange="doPasswordCheck()"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input id="reg-submit" type="submit" value="Register" disabled='disabled' class="btn btn-primary"></td>
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
                    <form autocomplete="off" method="post" action = "/api.php">
                        <input type="hidden" name="action" value="login">
                        <table>
                            <tr>
                                <td>Email&nbsp;&nbsp;&nbsp;</td>
                                <td><input autocomplete="none" type="email" name="email" id="login-email" onchange="doLoginCheck()"></td>
                            </tr>
                            <tr>
                                <td>Password&nbsp;&nbsp;&nbsp;</td>
                                <td><input autocomplete="false" type="password" name="password" id="login-password" onchange="doLoginCheck()"></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><input type="submit" id="login-submit" value="Login" disabled="disabled" class="btn btn-primary"></td>
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
<?php if ($msg) { ?>
<div class="modal-msg" style=" border: 1px solid white;position:fixed;top: 20%;left:20%; right:20%; background-color:rebeccapurple;color:white;font-size:120%;text-align:center;padding:21px; border-radius:2px;opacity:0.8;">
    <?php echo $msg; ?>
    <br/>
    <button class="btn btn-outline-light my-2 my-sm-0 msg-ok-button" onclick="$('.modal-msg').hide()">OK</button>
</div>
<?php } ?>

<div class="modal-new" style="display:none;border: 1px solid white;position:fixed;top: 20%;left:20%; right:20%; background-color:rebeccapurple;color:white;font-size:120%;text-align:center;padding:21px; border-radius:2px;opacity:0.8;">
    <form method="post" action="/api.php">
        <input type='hidden' name='action' value='new-program'>
        <input type='hidden' name='id' value='<?php echo $id; ?>'>
        <center>
        <table>
            <tr>
                <th>Twilio Number</th>
                <td><input type="text" name="phone" placeholder="+18005551234" id="new-phone"></td>
            </tr>



            <tr>
                <th colspan="2">
                    <br/>
                    Set your Webhook URL to <u>https://evodialer.com/basic.php</u>
                    <br/>
                    <br/>
                </th>
            </tr>

            <tr>
                <td colspan="2">
                    <input class="btn btn-outline-warning my-2 my-sm-0 create-button" onclick="$('.modal-new').hide()" type="submit" value="Create">
                    &nbsp;
                    <button class="btn btn-outline-danger my-2 my-sm-0 cancel-button" onclick="$('.modal-new').hide()">Cancel</button>
                </td>
            </tr>
        </table>
        </center>
    </form>
    <br/>

</div>
<?php if (isset($_SESSION['load'])) {
    $progId = $_SESSION['load'];
    unset($_SESSION['load']);
    ?>
<script>
   console.log('doLoad with <?php echo $progId; ?>');
   alert('Created Program ID <?php echo $progId; ?>');
   setTimeout(function() {
       doLoad('<?php echo $progId; ?>');
   },1000);

</script>
<?php } ?>
</body>
</html>
