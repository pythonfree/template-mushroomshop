<?php
session_start();
require_once __DIR__ . '/../db/db.php';

$cats = $dbh->query('SELECT * FROM cats;');
$cats = $cats->fetchAll(PDO::FETCH_ASSOC);

//var_dump($cats);

?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Shop</title>
    <link rel="stylesheet" href="css/style.css?<?= rand(0,PHP_INT_MAX);?>">
</head>
<body>

<nav>
    <ul>
        <li><a href="index.php">Главная</a></li>
        <?php foreach ($cats as $cat): ?>
            <li><a href="index.php?cat=<?= $cat['name'] ;?>"><?= $cat['rus_name'] ;?></a></li>
        <?php endforeach; ?>
        <li><a href="cart.php">Корзина (Товаров: <?= $_SESSION['totalQuantity'] ?? 0; ?> на сумму <?= $_SESSION['totalPrice'] ?? 0; ?> руб)</a></li>
    </ul>
</nav>
<hr>