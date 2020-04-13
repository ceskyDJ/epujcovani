<?php

declare(strict_types = 1);

/**
 * starter.php
 *
 * @author Michal Šmahel (ceskyDJ) <admin@ceskydj.cz>
 * @copyright (C) 2020-Současnost, Michal ŠMAHEL
 */

// Load required things and run Composer's autoloader
require_once __DIR__."/../vendor/autoload.php";

require_once __DIR__."/Database/DB.php";
require_once __DIR__."/Config/Configurator.php";

session_start();
mb_internal_encoding("UTF-8");

use App\Config\Configurator;
use Nette\Loaders\RobotLoader;

$configurator = new Configurator();
$loader = new RobotLoader();

// Configure loader
$loader->addDirectory(__DIR__);
$loader->setTempDirectory($configurator->getTempDir());
$loader->register();

// Get DB connection's instance
$db = $configurator->getDBConnection();