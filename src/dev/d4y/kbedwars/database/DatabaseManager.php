<?php

namespace dev\d4y\kbedwars\database;

use dev\d4y\kbedwars\database\provider\SQLiteProvider;
use dev\d4y\kbedwars\Entry;
use dev\d4y\kbedwars\helper\Log;
use dev\d4y\kbedwars\helper\PathHelper;
use Exception;
use InvalidArgumentException;

class DatabaseManager
{
    /** @var DatabaseProvider */
    private $currentProvider;

    /** @var Entry */
    private $plugin;

    /** @var bool */
    private $valid;

    /**
     * @return Entry
     */
    public function getPlugin(): Entry
    {
        return $this->plugin;
    }

    /**
     * @return DatabaseProvider
     */
    public function getCurrentProvider(): DatabaseProvider
    {
        return $this->currentProvider;
    }

    /**
     * @throws Exception
     */
    public function __construct(Entry $plugin)
    {
        $this->plugin = $plugin;
        $provider = $this->getDatabaseProvider($plugin);

        if (!$provider)
        {
            $this->valid = false;

            throw new Exception("There is no database provider available");
        }

        $this->valid = true;
        $this->currentProvider = $provider;
    }

    public function getDatabaseProvider(Entry $plugin)
    {
        $currentProvider = $this->getPlugin()->getConfiguration()->getDatabaseProvider();

        switch ($currentProvider) {
        case DatabaseProvider::SQLITE3:
            $filePath = PathHelper::mount($plugin->getDataFolder(), "kbedwars.db");

            if (!file_exists($folder = PathHelper::getParentDirectory($filePath)))
                @mkdir($folder);

            $provider = new SQLiteProvider($filePath);
            break;
        default:
            Log::error("A invalid database provider was set in the configuration file");

            return null;
        }

        return $provider;
    }

    public function close()
    {
        if (!$this->valid)
            return Log::warn("Tried to close a invalid instance of DatabaseManager");

        $this->getCurrentProvider()->close();
    }

}
