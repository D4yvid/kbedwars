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
