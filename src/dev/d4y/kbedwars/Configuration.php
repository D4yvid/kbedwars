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

use dev\d4y\kbedwars\helper\PathHelper;
use dev\d4y\vdb\provider\YamlProvider;

class Configuration
{

    /** @var YamlProvider */
    private $yamlProvider;

    /** @var Entry */
    private $plugin;

    /**
     * @return YamlProvider
     */
    public function getYamlProvider(): YamlProvider
    {
        return $this->yamlProvider;
    }

    /**
     * @return Entry
     */
    public function getPlugin(): Entry
    {
        return $this->plugin;
    }

    public function __construct(Entry $plugin)
    {
        $this->plugin = $plugin;
        $this->yamlProvider = new YamlProvider(
            $plugin,
            PathHelper::mount($plugin->getDataFolder(), "config.yml"),
            [
                "Database.Provider" => "sqlite",
                "Database.MySQL.Port" => 3306,
                "Database.MySQL.Host" => "127.0.0.1",
                "Database.MySQL.User" => "",
                "Database.MySQL.Password" => "",
                "Database.MySQL.DatabaseName" => "kbedwars-database"
            ]
        );
    }

    public function destroy()
    {
        $this->yamlProvider->save();
        $this->yamlProvider = NULL;
    }

    public function getDatabaseProvider(): string
    {
        return $this->yamlProvider->get("Database.Provider", "sqlite");
    }

    public function getDatabasePort(): int
    {
        return $this->yamlProvider->get("Database.MySQL.Port", 3306);
    }

    public function getDatabaseHost(): string
    {
        return $this->yamlProvider->get("Database.MySQL.Host");
    }

    public function getDatabasePassword(): string
    {
        return $this->yamlProvider->get("Database.MySQL.Password");
    }

    public function getDatabaseUser(): string
    {
        return $this->yamlProvider->get("Database.MySQL.User");
    }

    public function getDatabaseName(): string
    {
        return $this->yamlProvider->get("Database.MySQL.DatabaseName", null);
    }

}
