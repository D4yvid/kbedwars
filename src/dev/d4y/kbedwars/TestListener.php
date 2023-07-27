<?php

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