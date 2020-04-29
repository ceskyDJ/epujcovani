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
    $message = $carManager->editCar((int)$_GET['id'], $_POST['name'], $_POST['day-price'], $_FILES['image']);
}
?>
<!doctype html>


<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="author" content="Michal ŠMAHEL (ceskyDJ)" />
    <title>ŠMAHEL - Editace auta | ePujcovani.cz</title>
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
    <section class="content-section form-page">
        <section class="section-content edit-car">
            <?php if (isset($car)): ?>
                <form id="_add-car-form" method="post" class="admin-form" enctype="multipart/form-data">
                    <div class="data-inputs">
                        <div class="input-row">
                            <input id="_car-name-input" name="name" type="text" class="full-width-input" placeholder="Název auta" title="Zadejte název auta" autofocus value="<?= isset($_POST['name'])
                                ? $_POST['name'] : $car['name'] ?>" required pattern="^[A-Za-zĚŠČŘŽÝÁÍÉÚŮĎŤŇěščřžýáíéůúďťň0-9 ]+$" />
                        </div>
                        <div class="input-row">
                            <input id="_car-day-price-input" name="day-price" type="number" class="price-input" placeholder="Denní cena" title="Zadejte denní cenu za vypůjčení" value="<?= isset($_POST['day-price'])
                                ? $_POST['day-price'] : $car['day_price'] ?>" required pattern="^[0-9]+$" />
                        </div>
                        <img src="img/cars/<?= $car['image_name'] ?>" alt="Aktuální ilustrační obrázek auta" class="car-image" />
                        <div class="input-row">
                            <input id="_car-image-input" name="image" type="file" class="full-width-input" placeholder="Ilustrační obrázek" title="Vložte ilustrační obrázek" accept="image/*" required />
                        </div>
                    </div>

                    <input type="submit" value="Uložit" class="send-button">

                    <?php if (isset($message)): ?>
                        <p class="form-message _error-message"><?= $message ?></p>
                    <?php endif; ?>
                </form>
            <?php else: ?>
                <p>Auto nebylo nalezeno</p>
            <?php endif; ?>
        </section>
    </section>
</main>

<script src="https://kit.fontawesome.com/7d2f55cfde.js" crossorigin="anonymous"></script>
<script src="/js/classes/CarManager.js"></script>
<script src="/js/add-car.js"></script>
</body>
</html>