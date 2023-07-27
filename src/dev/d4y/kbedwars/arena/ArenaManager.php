<?php

namespace dev\d4y\kbedwars\arena;

use dev\d4y\kbedwars\Entry;
use dev\d4y\kbedwars\helper\Log;
use dev\d4y\kbedwars\helper\PathHelper;
use Exception;
use Phar;
use pocketmine\level\Level;
use RuntimeException;

class ArenaManager
{

    /** @var Arena[] */
    private $arenas;

    /** @var string */
    private $arenaPath;

    /** @var Entry */
    private $plugin;

    public function __construct(Entry $plugin)
    {
        $this->plugin = $plugin;
        $this->arenaPath = PathHelper::mount($plugin->getDataFolder(), "arenas/");

        $this->reload();
    }

    public function reload()
    {
        $arenas = &$this->arenas;
        $arenaPath = $this->arenaPath;

        $arenas = [];

        foreach (scandir($arenaPath) as $file) {
            if ($file[0] == '.') continue;
            if (is_dir(PathHelper::mount($arenaPath, $file))) continue;
            if (!stripos($file, ".tar.gz")) continue;

            Log::info("Loading arena $file");

            $this->tryLoadArena(str_replace(".tar.gz", "", $file));
        }
    }

    private function tryLoadArena(string $arenaName)
    {
        $path = PathHelper::mount($this->arenaPath, "$arenaName.tar.gz");

        if (!file_exists($path)) {
            return;
        }

        $this->arenas[$arenaName] = new Arena($this, $path);
    }

    private function trySaveArena(string $arenaName, string $levelFolder)
    {
        $worldPath = PathHelper::mount($this->getPlugin()->getServer()->getDataPath(), "worlds", $levelFolder);
        $filePath = PathHelper::mount($this->getArenasPath(), "$arenaName.tar.gz");

        if (file_exists($filePath))
            return;

        try {
            $file = new \PharData($filePath);

            $file->buildFromDirectory($worldPath);

            $file->compress(Phar::GZ);
        } catch (Exception $ignore) {
            /** ignore */
        }
    }

    /**
     * @param string $name
     * @param bool $loadIfUnloaded
     * @return Arena|null
     */
    public function getArenaByName(string $name, bool $loadIfUnloaded = false)
    {
        if (!isset($this->arenas[$name]) && $loadIfUnloaded)
            $this->tryLoadArena($name);

        return $this->arenas[$name] ?? null; // ignore warning about unchecked index
    }

    public function saveLevelAsArena(Level $level)
    {
        if (isset($this->arenas[$level->getName()]))
            throw new RuntimeException("There is already a arena with this name!");

        $folderName = $level->getFolderName();
        $name = $level->getName();

        $this->trySaveArena($name, $folderName);
    }

    /**
     * @return Entry
     */
    public function getPlugin(): Entry
    {
        return $this->plugin;
    }

    public function getArenasPath(): string
    {
        return $this->arenaPath;
    }

    /**
     * @return Arena[]
     */
    public function getArenas(): array
    {
        return $this->arenas;
    }

}
