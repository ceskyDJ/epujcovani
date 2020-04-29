<?php

declare(strict_types = 1);

/**
 * Index
 *
 * @author Michal Šmahel (ceskyDJ) <admin@ceskydj.cz>
 * @copyright (C) 2020-now, Michal ŠMAHEL
 */

use App\Model\CarManager;
use App\Utils\StringHelper;

require_once __DIR__.'/../src/starter.php';

$stringHelper = new StringHelper;
$carManager = new CarManager($db, $stringHelper);

$cars = $carManager->getCars();
?>
<!doctype html>


<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="author" content="Michal ŠMAHEL (ceskyDJ)" />
    <title>ŠMAHEL - ePujcovani.cz</title>
    <link rel="stylesheet" href="css/styles.css" type="text/css" />
</head>


<body>
<header class="page-header">
    <h1 class="main-heading">epůjčování.cz</h1>

    <nav class="main-menu">
        <ul class="menu-list">
            <li class="menu-item"><a href="#" class="menu-link">Podmínky</a></li>
            <li class="menu-item"><a href="#" class="menu-link">Kontakty</a></li>
            <li class="menu-item"><a href="vypujcky-administrace.php" class="menu-link">Administrace výpůjček</a></li>
        </ul>
    </nav>
</header>


<main class="page-content">
    <header class="content-header">
        <h2 class="content-heading">Nabídka aut k vypůjčení</h2>
    </header>


    <section class="content-section">
        <?php foreach ($cars as $car): ?>
        <article class="section-article rent-offer-article">
            <header class="rent-offer-header">
                <h3 class="rent-offer-heading"><?= $car['name'] ?></h3>
            </header>

            <section class="rent-offer-section">
                <img src="img/cars/<?= $car['image_name'] ?>" alt="Ilustrační obrázek: <?= $car['name'] ?>" class="car-image" />

                <p class="car-price">Cena: <?= $car['day_price'] ?>&nbsp;Kč za den</p>

                <a href="#" class="car-order">Objednat</a>
            </section>
        </article>
        <?php endforeach; ?>
    </section>
</main>
</body>
</html>
