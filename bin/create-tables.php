<?php

use Laminas\Crypt\Password\Bcrypt;
use Laminas\Db\Adapter\Adapter as DbAdapter;

include __DIR__ . '/../vendor/autoload.php';

$adapter = new DbAdapter([
    'driver' => 'Pdo_Mysql',
    'database' => 'soap_php',
    'username' => 'soap_php',
    'password' => 'password'
]);
// Build a simple table creation query
$sqlCreate = 'CREATE TABLE users ('
    . 'id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY, '
    . 'username VARCHAR(50) UNIQUE NOT NULL, '
    . 'password VARCHAR(100) NULL)';


$result = $adapter->query($sqlCreate);
$result -> execute();

$bcrypt = new Bcrypt();

// Build a query to insert a row for which authentication may succeed
$sqlInsert = "INSERT INTO users (username, `password`)"
    . "VALUES ('admin', '" . $bcrypt->create('password') .
    "')";
// Insert the data
    $stmt = $adapter->query($sqlInsert);
    $stmt ->execute();
//TABLA DE PRODUCTOS
$productCreate = 'CREATE TABLE products ('
    . 'id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY, '
    . 'nameproduct VARCHAR(50) UNIQUE NOT NULL, '
    . 'description VARCHAR(100) NULL )';

$result2 = $adapter->query($productCreate);
$result2->execute();





?>