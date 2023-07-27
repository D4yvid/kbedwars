<?php

/**
 * A simple BedWars plugin for PocketMine-MP
 * Copyright (C) 2023  Dayvid Albuquerque
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published
 * by the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */


namespace dev\d4y\kbedwars\database;

use dev\d4y\kbedwars\database\provider\MySQLProvider;
use dev\d4y\kbedwars\database\provider\SQLiteProvider;
use dev\d4y\kbedwars\Entry;
use dev\d4y\kbedwars\helper\Log;
use dev\d4y\kbedwars\helper\PathHelper;
use Exception;

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
        $this->valid = false;

        $provider = $this->getDatabaseProvider($plugin);

        if (!$provider)
            throw new Exception("There is no database provider available");

        Log::info("Using the database provider %s", get_class($provider));

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
        case DatabaseProvider::MYSQL:
            $hostname = $this->getPlugin()->getConfiguration()->getDatabaseHost();
            $port     = $this->getPlugin()->getConfiguration()->getDatabasePort() ?? 3306;
            $user     = $this->getPlugin()->getConfiguration()->getDatabaseUser();
            $password = $this->getPlugin()->getConfiguration()->getDatabasePassword();
            $database = $this->getPlugin()->getConfiguration()->getDatabaseName();

            if (!$hostname) {
                Log::warn("There is no valid hostname configured, using 127.0.0.1 instead.");

                $hostname = "127.0.0.1";
            }

            $provider = new MySQLProvider($database, $user, $password);
            $provider->connect($hostname, $port);

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
        {
            Log::warn("Tried to close a invalid instance of DatabaseManager");
            return false;
        }

        $this->getCurrentProvider()->close();
    }

    public function init()
    {
        $this->getCurrentProvider()->execute('
            CREATE TABLE IF NOT EXISTS PlayerData(
                hash            TEXT NOT NULL,
                uuid            TEXT NOT NULL,
                wins            INT NOT NULL,
                gamesPlayed     INT NOT NULL,
                kills           INT NOT NULL,
                finalKills      INT NOT NULL,
                bedsBroken      INT NOT NULL,
                winStreak       INT NOT NULL,
                level           INT NOT NULL,
                exp             INT NOT NULL,
                coins           INT NOT NULL
            )
        ');
    }

}
