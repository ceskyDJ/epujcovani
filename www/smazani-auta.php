<?php

declare(strict_types = 1);

/**
 * vlozeni-auta.php
 *
 * @author Michal Šmahel (ceskyDJ) <admin@ceskydj.cz>
 * @copyright (C) 2020-Současnost, Michal ŠMAHEL
 */

use App\Model\CarManager;
use App\Model\RentManager;
use App\Model\UserManager;
use App\Utils\StringHelper;

require_once __DIR__.'/../src/starter.php';

$stringHelper = new StringHelper;
$carManager = new CarManager($db, $stringHelper);

if (isset($_GET['id'])) {
    $car = $carManager->getCar((int)$_GET['id']);
}

if ($_POST) {
    $message = $carManager->deleteCar((int)$_GET['id']);
}
?>
<!doctype html>


<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="author" content="Michal ŠMAHEL (ceskyDJ)" />
    <title>ŠMAHEL - Smazání auta | ePujcovani.cz</title>
    <link rel="stylesheet" href="css/styles.css" type="text/css" />
</head>


<body>
<header class="page-header">
    <h1 class="main-heading">epůjčování.cz</h1>

    <nav class="main-menu">
        <ul class="menu-list">
            <li class="menu-item"><a href="index.php" class="menu-link">Nabídka</a></li>
            <li class="menu-item"><a href="administrace.php" class="menu-link">Administrace</a></li>
            <li class="menu-item"><a href="#" class="menu-link">Odhlášení</a></li>
        </ul>
    </nav>
</header>


<main class="page-content">
    <?php if (isset($car)): ?>
    <section class="content-section form-page">
        <header class="section-header">
            <h2 class="content-heading">Mercedes Benz</h2>
        </header>

        <section class="section-content">
            <article class="section-article rent-offer-article">
                <header class="rent-offer-header">
                    <h3 class="rent-offer-heading"><?= $car['name'] ?></h3>
                </header>

                <section class="rent-offer-section">
                    <img src="img/cars/<?= $car['image_name'] ?>" alt="Ilustrační obrázek: <?= $car['name'] ?>" class="car-image" />

                    <p class="car-price">Cena: <?= $car['day_price'] ?>&nbsp;Kč za den</p>
                </section>
            </article>
        </section>
    </section>

    <section class="content-section form-page second-section">
        <form id="_add-car-form" method="post" class="admin-form" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $car['car_id'] ?>" />

            <input type="submit" value="Smazat" class="send-button">

            <?php if (isset($message)): ?>
                <p class="form-message _error-message"><?= $message ?></p>
            <?php endif; ?>
        </form>
    </section>
    <?php else: ?>
        <section class="content-section form-page">
            <p>Auto nebylo nalezeno</p>
        </section>
    <?php endif; ?>
</main>

<script src="https://kit.fontawesome.com/7d2f55cfde.js" crossorigin="anonymous"></script>
<script src="/js/classes/CarManager.js"></script>
<script src="/js/add-car.js"></script>
</body>
</html>