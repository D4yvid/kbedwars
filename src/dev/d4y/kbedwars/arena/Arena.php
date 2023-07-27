<?php

namespace dev\d4y\kbedwars\arena;

use dev\d4y\kbedwars\helper\PathHelper;
use Exception;
use PharData;
use pocketmine\level\Level;
use RuntimeException;

class Arena
{

    /** @var string */
    private $backupFilePath;

    /** @var ArenaManager */
    private $arenaManager;

    /**
     * @return string
     */
    public function getBackupFilePath(): string
    {
        return $this->backupFilePath;
    }

    /**
     * @return ArenaManager
     */
    public function getArenaManager(): ArenaManager
    {
        return $this->arenaManager;
    }

    public function __construct(ArenaManager $arenaManager, string $backupFilePath)
    {
        $this->arenaManager = $arenaManager;
        $this->backupFilePath = $backupFilePath;
    }

    /**
     * @throws Exception
     */
    public function loadAsNewLevel(string $levelName = null): Level
    {
        $path = $this->backupFilePath;
        $plugin = $this->getArenaManager()->getPlugin();

        if (!file_exists($path)) {
            throw new RuntimeException("The backup file was not found");
        }

        if (!$levelName)
            $levelName = str_replace(".tar.gz", "", basename($this->backupFilePath)) . bin2hex(random_bytes(10));

        $worldsPath = PathHelper::mount($plugin->getServer()->getDataPath(), "worlds");

        $file = new PharData($path);

        if (!$file->valid())
            throw new RuntimeException("The backup file is corrupted or is unreadable");

        $file->extractTo(PathHelper::mount($worldsPath, $levelName));

        if (!$plugin->getServer()->loadLevel($levelName))
            throw new RuntimeException("Could not load the level");

        return $plugin->getServer()->getLevelByName($levelName);
    }

}