<?php

namespace dev\d4y\kbedwars\game\event;

use dev\d4y\kbedwars\game\GameEvent;
use dev\d4y\kbedwars\helper\TickHelper;
use pocketmine\utils\UUID;

class GeneratorUpgradeEvent extends GameEvent
{

	const DIAMOND_GENERATOR = 0b01;
	const EMERALD_GENERATOR = 0b10;

	function tick(): bool
	{
		return true;
	}

	function execute(): bool
	{
		return true;
	}

	public static function new(int $generatorType = self::DIAMOND_GENERATOR, int $upgradeToLevel = 1)
	{
		$generatorName = null;

		switch ($generatorType)
		{
		case self::DIAMOND_GENERATOR: $generatorName = "KBedwars.Generator.Diamond"; break;
		case self::EMERALD_GENERATOR: $generatorType = "KBedwars.Generator.Emerald"; break;
		}

		assert($generatorName);

		return new GeneratorUpgradeEvent(
			UUID::fromRandom(),
			"$generatorName $upgradeToLevel",
			$upgradeToLevel * (TickHelper::MINUTE_IN_TICK * 2.5)
		);
	}

}
