<?php

declare(strict_types = 1);

/**
 * vypujcky-administrace.php
 *
 * @author Michal Šmahel (ceskyDJ) <admin@ceskydj.cz>
 * @copyright (C) 2020-Současnost, Michal ŠMAHEL
 */

use App\Model\CarManager;
use App\Model\RentManager;
use App\Model\UserManager;

require_once __DIR__.'/../src/starter.php';

$carManager = new CarManager($db);
$userManager = new UserManager($db);
$rentManager = new RentManager($db, $carManager, $userManager);

$rents = $rentManager->getActualRents();
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
            <li class="menu-item"><a href="index.php" class="menu-link">Nabídka</a></li>
            <li class="menu-item"><a href="vypujcky-administrace.php" class="menu-link">Administrace</a></li>
            <li class="menu-item"><a href="#" class="menu-link">Odhlášení</a></li>
        </ul>
    </nav>
</header>


<main class="page-content">
    <section class="content-section">
        <?php foreach ($rents as $rent): ?>
        <article class="section-article done-rent-article">
            <div class="car-info">
                <h3 class="car-name"><?= $rent['car']['name'] ?></h3>
                <img src="img/<?= $rent['car']['image_name'] ?>" alt="Ilustrační fotografie: <?= $rent['car']['name'] ?>" class="car-image" />
                <p class="car-price">Cena: <?= $rent['car']['day_price'] ?>&nbsp;Kč za den</p>
            </div>

            <div class="other-data">
                <div class="user-info">
                    <h3 class="user-full-name"><?= $rent['user']['full_name'] ?></h3>
                    <p class="user-email"><?= $rent['user']['email'] ?></p>
                    <p class="user-phone"><?= $rent['user']['phone'] ?></p>
                </div>

                <div class="rent-info">
                    <h3 class="rent-date"><?= $rent['from']->format("j. n. Y") ?>-<?= $rent['to']->format("j. n. Y") ?></h3>
                    <p class="rent-length"><?= $rent['length'] ?></p>
                    <p class="rent-price"><?= $rent['price'] ?>&nbsp;Kč</p>

                    <div class="tools">
                        <a href="#" class="edit-rent"><i class="fas fa-pen"></i></a>
                        <a href="#" class="delete-rent"><i class="fas fa-trash"></i></a>
                    </div>
                </div>
            </div>
        </article>
        <?php endforeach; ?>
    </section>
</main>

<script src="https://kit.fontawesome.com/7d2f55cfde.js" crossorigin="anonymous"></script>
</body>
</html>