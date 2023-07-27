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

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\level\Location;

class TestListener implements Listener
{

    private $plugin;

    public function __construct(Entry $plugin)
    {
        $this->plugin = $plugin;
    }

    /**
     * @throws \Exception
     */
    public function onPlayerChat(PlayerChatEvent $event)
    {
        $p = $event->getPlayer();

        if (strpos($event->getMessage(), "savelevel")) {
            $p->sendMessage("Saving arena {$p->getLevel()->getName()}");

            $this->plugin->getArenaManager()->saveLevelAsArena($p->getLevel());

            $event->setCancelled();
        }
        else if (strpos($event->getMessage(), "loadlevel")) {
            $p->sendMessage("Loading arena {$p->getLevel()->getName()}");

            $arena = $this->plugin->getArenaManager()->getArenaByName($p->getLevel()->getName());

            if (!$arena)
            {
                $p->sendMessage("Arena not found");
                return;
            }

            $level = $arena->loadAsNewLevel();

            $p->teleport(new Location($p->x, $p->y, $p->z, $p->pitch, $p->yaw, $level));
        }
    }

    public function onInteract(PlayerInteractEvent $event)
    {
        $p = $event->getPlayer();

        $p->sendMessage("Block Id: {$event->getBlock()->getId()}");
    }

}
