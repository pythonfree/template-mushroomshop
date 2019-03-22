<?php

require_once __DIR__ . '/parts/header.php';

if (isset($_GET['cat'])){
    $currentCat = $_GET['cat'];
    $products = $dbh->query("SELECT * FROM products WHERE cat='$currentCat'", PDO::ATTR_ERRMODE);
    $products = $products->fetchAll(PDO::FETCH_ASSOC);
    if (empty($products)){
        die(
                '<h1 class="cart-title">Подождем четверга... и тогда грибочки этой категории обязательно нас порадуют!</h1>
                 </body>
                 </html>   
                 '
        );
    }
} else {
    $products = $dbh->query("SELECT * FROM products");
    $products = $products->fetchAll(PDO::FETCH_ASSOC);
}


?>

    <div class="main">
        <?php foreach ($products as $product): ?>
        <div class="card">
            <a href="product.php?product=<?= $product['title']; ?>">
                <img src="img/<?= $product['img']; ?>" alt="<?= $product['rus_name']; ?>">
            </a>
            <div class="label"><?= $product['rus_name']; ?> (<?= $product['price']; ?> рублей)</div>
            <?php require __DIR__ . '/parts/add-form.php'; ?>
        </div>
        <?php endforeach; ?>
    </div>

</body>
</html>

