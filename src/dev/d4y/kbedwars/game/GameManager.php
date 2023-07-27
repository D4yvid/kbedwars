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

