<?php

namespace dev\d4y\kbedwars;

use dev\d4y\kbedwars\database\DatabaseManager;
use dev\d4y\kbedwars\helper\Log;
use pocketmine\plugin\PluginBase;
use RuntimeException;

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

    public function __construct()
    {
        Log::init($this);
    }

    public function onLoad()
    {
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

}
