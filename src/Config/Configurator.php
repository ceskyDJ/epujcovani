<?php

declare(strict_types = 1);

namespace App\Config;

use App\Database\DB;
use Nette\Bridges\DatabaseTracy\ConnectionPanel;
use Tracy\Debugger;
use function realpath;

/**
 * Config manager
 *
 * @author Michal Šmahel (ceskyDJ) <admin@ceskydj.cz>
 * @copyright (C) 2020-Současnost, Michal ŠMAHEL
 * @package App\Config
 */
class Configurator
{
    /**
     * Config file path (from app's src root dir)
     */
    private const CONFIG_FILE = "Config/config.ini";

    /**
     * @var \App\Database\DB Database connection
     */
    private $db;
    /**
     * @var array Loaded configs from config file
     */
    private $configs;
    /**
     * @var string Path to directory for temporary files
     */
    private $tempDir;
    /**
     * @var string Path to directory for log files
     */
    private $logDir;

    /**
     * Configurator constructor
     */
    public function __construct()
    {
        $this->loadConfigs();
        $this->setDirectoriesFromConfigs();

        $this->createDBConnection();
        $this->setupTracy();
    }

    /**
     * Loads config from config file
     */
    private function loadConfigs(): void
    {
        $file = "{$this->getAppSrcRootDir()}/".self::CONFIG_FILE;

        $this->configs = parse_ini_file($file, true, INI_SCANNER_TYPED);
    }

    private function createDBConnection(): void
    {
        $dbConfig = $this->getDatabaseConfig();

        $this->db = new DB($dbConfig['host'], (int)$dbConfig['port'], $dbConfig['database'], $dbConfig['user-name'], $dbConfig['user-password']);
    }

    private function setupTracy(): void
    {
        Debugger::enable(Debugger::DETECT, $this->getLogDir());

        Debugger::getBar()->addPanel(new ConnectionPanel($this->db), "db");
    }

    /**
     * Sets up paths from configs
     */
    private function setDirectoriesFromConfigs(): void
    {
        $this->setTempDir($this->configs['paths']['temp']);
        $this->setLogDir($this->configs['paths']['log']);
    }

    public function getDBConnection(): DB
    {
        return $this->db;
    }

    /**
     * Getter for tempDir
     *
     * @return string
     */
    public function getTempDir(): string
    {
        return $this->tempDir;
    }

    /**
     * Fluent setter for tempDir
     *
     * @param string $tempDir
     */
    public function setTempDir(string $tempDir): void
    {
        $this->tempDir = realpath($this->getAppSrcRootDir()."/../{$tempDir}");
    }

    /**
     * Getter for logDir
     *
     * @return string
     */
    public function getLogDir(): string
    {
        return $this->logDir;
    }

    /**
     * Fluent setter for logDir
     *
     * @param string $logDir
     */
    public function setLogDir(string $logDir): void
    {
        $this->logDir = realpath($this->getAppSrcRootDir()."/../{$logDir}");
    }

    /**
     * Returns database config
     *
     * @return array Database config
     */
    public function getDatabaseConfig(): array
    {
        return $this->configs['database'];
    }

    /**
     * Returns app's src root dir
     *
     * @return string Apps' src root directory
     */
    public function getAppSrcRootDir(): string
    {
        return realpath(__DIR__."/..");
    }
}