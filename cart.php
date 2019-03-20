<?php
require_once __DIR__ . '/parts/header.php';
?>

<?php foreach ($_SESSION['cart'] as $id => $product): ?>
<div class="cart">
    <a href="product.php?product=<?= $product['title'] ;?>"><img src="img/<?= $product['img']; ?>" alt="<?= $product['rus_name']; ?>>"></a>
    <div class="cart-descr">
        <?= $product['rus_name']; ?> в количестве <?= $product['quantity']; ?> шт на сумму <?= $product['quantity'] * $product['price']; ?> рублей
    </div>
    <button type="submit">Удалить</button>
</div>
<?php endforeach; ?>

<hr>

</body>
</html>

