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
