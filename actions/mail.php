<?php
session_start();
require_once __DIR__ . '/../db/db.php';

if (isset($_POST['order'])){
    $cols = [];
    $data = [];
    foreach ($_POST as $k => $v){
        if ('order' === $k){
            continue;
        }
        $cols[] = $k;
        $data[':' . $k] = $v;
    }

    $sql = 'INSERT INTO ' .
        '`order`' . ' 
            (' . implode(',', $cols) . ') 
            VALUES 
            (' . implode(',', array_keys($data)) . ')
            '
    ;

    $sth = $dbh->prepare($sql);
    $sth->execute($data);


/*    $connect->query("INSERT INTO `order` (username, phone, email)
                                        VALUES ('$username', '$phone', '$email')");*/

    $lastId = $dbh->lastInsertId();

    //письмо клиенту
    $message = "<h2>Здравствуйте, ваш заказ под номером $lastId принят.</h2>";
    $message .= "<h3>Состав заказа:</h3>";
    foreach ($_SESSION['cart'] as $product){
        $message .= "<div>{$product['rus_name']} в количестве {$product['quantity']} шт.</div>";
    }
    $message .= "<p>Сумма заказа: {$_SESSION['totalPrice']} рублей</p>";
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
    $subject = "Ваш заказ под номером $lastId принят";
    mail($_POST['email'], $subject, $message, $headers);

    //письмо админу сайта
    $message = "<h2>ADMIN, заказ под номером $lastId отправлен на {$_POST['email']}.</h2>";
    $message .= "<h3>Состав заказа:</h3>";
    foreach ($_SESSION['cart'] as $product){
        $message .= "<div>{$product['rus_name']} в количестве {$product['quantity']} шт.</div>";
    }
    $message .= "<p>Сумма заказа: {$_SESSION['totalPrice']} рублей</p>";
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
    $subject = "Заказ под номером $lastId отправлен на {$_POST['email']}";
    mail('admin@mushroomshop.ru', $subject, $message, $headers);


    unset($_SESSION['totalQuantity'], $_SESSION['totalPrice'], $_SESSION['cart']);

    $_SESSION['order'] = $lastId;

    header("Location: {$_SERVER['HTTP_REFERER']}");
}