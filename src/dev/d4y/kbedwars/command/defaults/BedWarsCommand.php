<?php

namespace dev\d4y\kbedwars\command\defaults;

use dev\d4y\kbedwars\command\CommandBase;
use dev\d4y\kbedwars\Entry;
use pocketmine\command\CommandSender;

class BedWarsCommand extends CommandBase
{

    public function __construct(Entry $plugin)
    {
        parent::__construct($plugin, "bedwars", null, true, []);
    }

    public function execute(CommandSender $sender, array $args)
    {
        $this->getPlugin()->getGameManager()->
    }

}