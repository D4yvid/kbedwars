<?php

namespace dev\d4y\kbedwars;

use dev\d4y\kbedwars\arena\ArenaManager;
use dev\d4y\kbedwars\database\DatabaseManager;
use dev\d4y\kbedwars\game\GameManager;
use dev\d4y\kbedwars\helper\Log;
use Exception;
use pocketmine\plugin\PluginBase;

class Entry extends PluginBase
{

    /** @var GameManager */
    private $gameManager;

    /** @var ArenaManager */
    private $arenaManager;

    /** @var DatabaseManager */
    private $databaseManager;

    /** @var Configuration */
    private $configuration;

    /**
     * @return GameManager
     */
    public function getGameManager(): GameManager
    {
        return $this->gameManager;
    }

    /**
     * @return ArenaManager
     */
    public function getArenaManager(): ArenaManager
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

    /**
     * @throws Exception
     */
    public function onLoad()
    {
        @mkdir($this->getDataFolder());

        $this->configuration = new Configuration($this);
        $this->databaseManager = new DatabaseManager($this);
        $this->arenaManager = new ArenaManager($this);

        $this->gameManager = new GameManager($this);
    }

    public function onEnable()
    {
        $this->getDatabaseManager()->init();

        $this->getServer()->getPluginManager()->registerEvents(new TestListener($this), $this);
    }

    public function onDisable()
    {
        $this->getConfiguration()->destroy();
        $this->getDatabaseManager()->close();
    }

}
