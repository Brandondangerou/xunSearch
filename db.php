<?php
// 连接数据库 pdo
// 库名
$dbname = 'article';
$dbuser = 'xunsearch';
$dbpwd = 'xunsearch';
$charset = 'utf8mb4';

$pdo = new PDO('mysql:host=127.0.0.1;dbname=' . $dbname . ';charset=' . $charset, $dbuser, $dbpwd, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    // 取出的结果就为关联数组
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
]);

return $pdo;