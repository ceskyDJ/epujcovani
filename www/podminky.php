<?php

declare(strict_types = 1);

/**
 * Index
 *
 * @author Michal Šmahel (ceskyDJ) <admin@ceskydj.cz>
 * @copyright (C) 2020-now, Michal ŠMAHEL
 */

use App\Model\CarManager;
use App\Model\ImageManager;
use App\Utils\StringHelper;

require_once __DIR__.'/../src/starter.php';

$stringHelper = new StringHelper;
$imageManager = new ImageManager($stringHelper);

$images = $imageManager->getAllImages();
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

    <?php $type = "normal"; include "menu.php"; ?>
</header>


<main class="page-content">
    <header class="content-header white-background">
        <h2 class="content-heading">Podmínky rezervace</h2>

        <p class="after-heading-text">Jestliže si přejete Vaši rezervaci zrušit, jsme schopni Vám vrátit peníze v případě, že tak učíníte do 2 dnů
            před termínem rezervace. Bohužel později už Vám peníze vrátit nedokážeme, protože vozidlo bylo rezervováno
            na odsouhlasený termín.</p>
    </header>


    <section class="content-section">
        <?php foreach ($images as $image): ?>
            <article class="section-article rent-offer-article">
                <section class="rent-offer-section">
                    <img src="img/cars/<?= $image ?>" alt="Ilustrační obrázek: <?= $image ?>" class="car-image" />
                </section>
            </article>
        <?php endforeach; ?>
    </section>
</main>
</body>
</html>
