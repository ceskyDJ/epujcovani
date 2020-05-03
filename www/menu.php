<?php

declare(strict_types = 1);

/**
 * menu.php
 *
 * @author Michal Šmahel (ceskyDJ) <admin@ceskydj.cz>
 * @copyright (C) 2020-Současnost, Michal ŠMAHEL
 */

?>
<?php if (!isset($type) || $type === "normal-main"): ?>
    <nav class="main-menu">
        <ul class="menu-list">
            <li class="menu-item"><a href="podminky.php" class="menu-link">Podmínky</a></li>
            <li class="menu-item"><a href="#" class="menu-link">Kontakty</a></li>
            <li class="menu-item"><a href="administrace.php" class="menu-link">Administrace</a></li>
        </ul>
    </nav>
<?php elseif ($type === "normal"): ?>
    <nav class="main-menu">
        <ul class="menu-list">
            <li class="menu-item"><a href="index.php" class="menu-link">Nabídka</a></li>
            <li class="menu-item"><a href="#" class="menu-link">Kontakty</a></li>
            <li class="menu-item"><a href="administrace.php" class="menu-link">Administrace</a></li>
        </ul>
    </nav>
<?php elseif ($type === "admin-main"): ?>
    <nav class="main-menu">
        <ul class="menu-list">
            <li class="menu-item"><a href="index.php" class="menu-link">Nabídka</a></li>
            <li class="menu-item"><a href="vypujcky-administrace.php" class="menu-link">Administrace výpůjček</a></li>
        </ul>
    </nav>
<?php elseif ($type === "admin"): ?>
    <nav class="main-menu">
        <ul class="menu-list">
            <li class="menu-item"><a href="index.php" class="menu-link">Nabídka</a></li>
            <li class="menu-item"><a href="administrace.php" class="menu-link">Administrace</a></li>
            <li class="menu-item"><a href="#" class="menu-link">Odhlášení</a></li>
        </ul>
    </nav>
<?php endif; ?>