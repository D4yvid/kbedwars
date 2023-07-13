<?php

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