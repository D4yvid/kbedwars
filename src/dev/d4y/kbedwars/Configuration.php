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
                "Database.Provider" => "mysql"
            ]
        );
    }

    public function getDatabaseProvider(): string
    {
        return $this->yamlProvider->get("Database.Provider", "sqlite");
    }

    public function destroy()
    {
        $this->yamlProvider->save();
        $this->yamlProvider = NULL;
    }

}