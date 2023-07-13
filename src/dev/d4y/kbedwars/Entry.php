<?php

namespace dev\d4y\kbedwars;

use dev\d4y\kbedwars\database\DatabaseManager;
use dev\d4y\kbedwars\helper\PathHelper;
use http\Exception\RuntimeException;
use pocketmine\plugin\PluginBase;

class Entry extends PluginBase
{

    private $gameManager;
    private $arenaManager;

    /** @var DatabaseManager */
    private $databaseManager;

    /** @var Configuration */
    private $configuration;

    /**
     * @return mixed
     */
    public function getGameManager()
    {
        return $this->gameManager;
    }

    /**
     * @return mixed
     */
    public function getArenaManager()
    {
        return $this->arenaManager;
    }

    /**
     * @return DatabaseManager
     */
    public function getDatabaseManager(): DatabaseManager
    {
        return $this->databaseManager;
    }

    /**
     * @return Configuration
     */
    public function getConfiguration(): Configuration
    {
        return $this->configuration;
    }

    /** @var self */
    private static $instance;

    public function __construct()
    {
        if (self::$instance != NULL)
        {
            throw new RuntimeException("There is already a instance of " . get_class() . " created");
        }

        self::$instance = $this;
    }

    public function onLoad()
    {
        assert(self::get() != NULL);
        @mkdir($this->getDataFolder());

        $this->configuration = new Configuration($this);
        $this->databaseManager = new DatabaseManager($this);
    }

    public function onEnable()
    {
    }

    public function onDisable()
    {
        $this->getConfiguration()->destroy();
        $this->getDatabaseManager()->close();
    }

    public static function get(): self
    {
        return self::$instance;
    }

}