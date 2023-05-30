<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$action = false;
if (isset($_REQUEST['action'])) $action = $_REQUEST['action'];

if (!$action) {
    $_SESSION['msg'] = 'Invalid API action';
    header('Location: /');
    exit;
}

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
    $_SESSION['msg'] = $e->getMessage();
    header('Location: /');
    exit;
    //throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

switch ($action) {
// case action = code

    case 'new-program':
        if (isset($_POST['id'])) {

            $id = $_POST['id'];

            $phone = $_REQUEST['phone'];
            $sql = "SELECT * FROM twilite WHERE `To` LIKE '%$$phone%'";
            $stmt = $pdo->prepare($sql);
            $r = $stmt->execute();
            $rows = $stmt->fetchAll();
            //var_dump($rows);
            if ($rows) {
                $_SESSION['msg'] = "Twilio Phone Number $phone is already in use";
                header('Location: /');
                exit;
            }
            $code = "say \"Hello World\"";
            $sql = "INSERT INTO twilite SET `To` = ?, `code` = ?, `user_id` = ?";
            $stmt = $pdo->prepare($sql);
            $r = $stmt->execute([$phone, $code, $id]);
            $_SESSION['load'] = $pdo->lastInsertId();
            header('Location: /');
            exit;
        }
        break;

    case 'code':

        if (isset($_GET['id'])) {

            $id = $_GET['id'];

            $sql = "SELECT * FROM twilite WHERE `id` = $id";
            $stmt = $pdo->prepare($sql);
            $r = $stmt->execute();
            $rows = $stmt->fetchAll();

            if ($rows) {
                $row = $rows[0];
                exit(json_encode($row));
            }
        }
        if (isset($_POST['id'])) {

            $id = $_POST['id'];
            $code = $_POST['code'];
            $To = $_POST['To'];

            if ($id == '0') {
                $sql = "INSERT INTO twilite SET `To` = ?, `code` = ?";
                $stmt = $pdo->prepare($sql);
                $r = $stmt->execute([$To, $code]);

            } else {
                $sql = "UPDATE twilite SET `To` = ?, `code` = ? WHERE `id` = ?";
                $stmt = $pdo->prepare($sql);
                $r = $stmt->execute([$To, $code, $id]);
            }

            // TODO:
            exit(json_encode('OK')); // Need to send back ID so as we can do updates later without refreshing the page
        }
        break;

    case 'logout':
            unset($_SESSION['id']);
            $_SESSION['msg'] = 'You have been logged out';
            header('Location: /');
        break;

    case 'login':

        $email = $_POST['email'] ?? false;
        $password = $_POST['password'] ?? false;

        if (!$email or !$password) {
            $_SESSION['msg'] = 'Invalid Login Info';
            header('Location: /');
        }

        try {
            $sql = "SELECT * FROM users WHERE `email` = ? and `password` = ?";
            $stmt = $pdo->prepare($sql);
            $r = $stmt->execute([$email, $password]);
            $rows = $stmt->fetchAll();
        } catch (\PDOException $e) {
            $_SESSION['msg'] = $e->getMessage();
            header('Location: /');
            exit;
        }

        if ($rows) {
            $row = $rows[0];
            $_SESSION['id'] = $row['id'];
            header('Location: /');
            exit;
        }

        break;

    case 'register':

        $id = $_POST['id'] ?? false;
        $name = $_POST['name'] ?? false;
        $email = $_POST['email'] ?? false;
        $password = $_POST['password'] ?? false;
        $password2 = $_POST['password2'] ?? false;

        if (!$name or !$email or !$password or !$password2 ) {

            $_SESSION['msg'] = 'Invalid Registration Info';
            header('Location: /');
        }



        if ($id == '0') {

            try {
                $sql = "SELECT * FROM users WHERE `email` = ?";
                $stmt = $pdo->prepare($sql);
                $r = $stmt->execute([$email]);
                $rows = $stmt->fetchAll();
            } catch (\PDOException $e) {
                $_SESSION['msg'] = $e->getMessage();
                header('Location: /');
                exit;
            }

            if ($rows) {
                $_SESSION['msg'] = 'Invalid Registration Info: Email Already Exists';
                header('Location: /');
                exit;
            }

            try {
                $sql = "INSERT INTO users SET `name` = ?, `email` = ?, `password` = ?";
                $stmt = $pdo->prepare($sql);
                $r = $stmt->execute([$name, $email, $password]);
                $_SESSION['id'] = $pdo->lastInsertId();

                $sql = "INSERT INTO twilite SET `user_id` = ?, `To` = ? , `code` = ?";
                $stmt = $pdo->prepare($sql);
                $code = 'say "I\'m sorry, a twilight program has not been created for this phone number!"';
                $r = $stmt->execute([$_SESSION['id'], 'default', $code]);

                header('Location: /');
                exit;
            } catch (\PDOException $e) {
                $_SESSION['msg'] = $e->getMessage();
                header('Location: /');
                exit;
            }
        }
//        else {
//        $sql = "UPDATE users SET `name` = ?, `email` = ?, `password` = ? WHERE `id` = ?";
//        $stmt = $pdo->prepare($sql);
//        $r = $stmt->execute([$name, $email, $password, $id]);
//        }


        break;

    default:

        $_SESSION['msg'] = 'Unknown API Action: ' . $action;
        header('Location: /');

}