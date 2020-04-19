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

if ($_POST) {
    $message = $carManager->addCar($_POST['name'], $_POST['day-price'], $_FILES['image']);
}
?>
<!doctype html>


<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="author" content="Michal ŠMAHEL (ceskyDJ)" />
    <title>ŠMAHEL - Vložení nového auta | ePujcovani.cz</title>
    <link rel="stylesheet" href="css/styles.css" type="text/css" />
</head>


<body>
<header class="page-header">
    <h1 class="main-heading">epůjčování.cz</h1>

    <nav class="main-menu">
        <ul class="menu-list">
            <li class="menu-item"><a href="index.php" class="menu-link">Nabídka</a></li>
            <li class="menu-item"><a href="vypujcky-administrace.php" class="menu-link">Administrace</a></li>
            <li class="menu-item"><a href="vlozeni-auta.php" class="menu-link">Vložení auta</a></li>
            <li class="menu-item"><a href="#" class="menu-link">Odhlášení</a></li>
        </ul>
    </nav>
</header>


<main class="page-content">
    <section class="content-section form-page">
        <header class="section-header">
            <h2 class="content-heading">Vložení nového auta</h2>
        </header>

        <section class="section-content">
            <form id="_add-car-form" method="post" class="admin-form" enctype="multipart/form-data">
                <div class="data-inputs">
                    <div class="input-row">
                        <input id="_car-name-input" name="name" type="text" class="full-width-input" placeholder="Název auta" title="Zadejte název auta" autofocus value="<?= isset($_POST['name'])
                            ? $_POST['name'] : "" ?>" required />
                    </div>
                    <div class="input-row">
                        <input id="_car-day-price-input" name="day-price" type="number" class="price-input" placeholder="Denní cena" title="Zadejte denní cenu za vypůjčení" value="<?= isset($_POST['day-price'])
                            ? $_POST['day-price'] : "" ?>" required pattern="^[0-9]+$" />
                    </div>
                    <div class="input-row">
                        <input id="_car-image-input" name="image" type="file" class="full-width-input" placeholder="Ilustrační obrázek" title="Vložte ilustrační obrázek" accept="image/*" required />
                    </div>
                </div>

                <input type="submit" value="Uložit" class="send-button">

                <?php if (isset($message)): ?>
                    <p class="form-message _error-message"><?= $message ?></p>
                <?php endif; ?>
            </form>
        </section>
    </section>
</main>

<script src="https://kit.fontawesome.com/7d2f55cfde.js" crossorigin="anonymous"></script>
<script src="/js/classes/CarManager.js"></script>
<script src="/js/add-car.js"></script>
</body>
</html>