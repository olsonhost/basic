<?php

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

$id = $_GET['id'];

$sql = "SELECT * FROM twilite WHERE `id` = $id";
$stmt = $pdo->prepare($sql);
$r = $stmt->execute();
$rows = $stmt->fetchAll();
//var_dump($rows);
if ($rows) {
    $row=$rows[0];
    exit(json_encode($row));
}
