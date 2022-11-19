<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Заказы</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include 'header.php'; ?>

<div class="heading">
    <h3 class="orders">РАЗМЕЩЕННЫЕ ЗАКАЗЫ</h3>
    <!-- <p><a href="home.php">Главный</a> / заказы </p> -->
</div>

<section class="placed-orders">

    <h1 class="title">ВАШИ ЗАКАЗЫ</h1>

    <div class="box-container">

        <?php
        $order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE user_id = '$user_id'")
        or die('query failed');
        if (mysqli_num_rows($order_query) > 0) {
            while ($fetch_orders = mysqli_fetch_assoc($order_query)) {
                ?>
                <div class="box">
                    <p>Размещен : <span> <?php echo $fetch_orders['placed_on']; ?> </span></p>
                    <p>Имя : <span> <?php echo $fetch_orders['name']; ?> </span></p>
                    <p>Телефон : <span> <?php echo $fetch_orders['number']; ?> </span></p>
                    <p>Эл.Почта : <span> <?php echo $fetch_orders['email']; ?> </span></p>
                    <p>Адресс : <span> <?php echo $fetch_orders['address']; ?> </span></p>
                    <p>Способ оплаты : <span> <?php echo $fetch_orders['method']; ?> </span></p>
                    <p>Ваши заказы : <span> <?php echo $fetch_orders['total_products']; ?> </span></p>
                    <p>Итоговая цена : <span>$<?php echo $fetch_orders['total_price']; ?>/-</span></p>
                    <p> Статус платежа : <span style="color:<?php
                        if($fetch_orders['payment_status'] == 'В ожидании') {
                            echo 'red';
                        } else {
                            if ($fetch_orders['payment_status'] == 'Завершенный') {
                                echo 'green';
                            }
                        } 
                        ?>;"><?php
                            echo $fetch_orders['payment_status']; ?> </span>
                    </p>
                </div>
                <?php
            }
        } else {
            echo '<p class="empty">Еще нет заказов!</p>';
        }
        ?>
    </div>
</section>

<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>