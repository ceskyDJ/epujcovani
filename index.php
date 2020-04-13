<?php

declare(strict_types = 1);

/**
 * Redirect to www/ directory on production server
 *
 * @author Michal Šmahel (ceskyDJ) <admin@ceskydj.cz>
 * @copyright (C) 2020-Současnost, Michal ŠMAHEL
 */

if($_SERVER['SERVER_NAME'] !== "smahelmi.llmp.spse-net.cz") {
    return;
}

header("Location: /www");
exit;