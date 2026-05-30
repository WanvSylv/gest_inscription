<?php
try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306', 'root', '');
    $pdo->exec('CREATE DATABASE IF NOT EXISTS gest_inscription;');
    echo 'Database created successfully.';
} catch(PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
