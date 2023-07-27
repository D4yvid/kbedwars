<?php

namespace dev\d4y\kbedwars\game;

use dev\d4y\kbedwars\Entry;
use pocketmine\level\Level;

class GameManager
{

    /** @var Game[] */
    private $games = [];
    private $plugin;

    public function __construct(Entry $plugin)
    {
        $this->plugin = $plugin;
    }

    public function newGame()
    {
        if (($game = $this->findGame())) {
            return $game;
        }


    }

    public function findGame()
    {

    }

    public function deleteGame(Game $game)
    {

    }

    /**
     * @param Level $level
     * @return Level|null
     */
    public function getGameByLevel(Level $level)
    {
        foreach ($this->games as $game) {
            if ($game->getLevel()->getFolderName() == $level->getFolderName()) {
                return $game;
            }
        }

        return null;
    }

}

