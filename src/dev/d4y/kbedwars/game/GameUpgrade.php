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

use pocketmine\utils\UUID;

abstract class GameUpgrade
{

	/** @var UUID */
	private $id;

	/** @var string */
	private $name;

	/** @var BedwarsTeam */
	private $team;

	public function __construct(UUID $id, string $name, BedwarsTeam $team)
	{
		$this->id = $id;
		$this->name = $name;
		$this->team = $team;
	}

	public function id(): UUID
	{
		return $this->id;
	}

	public function name(): string
	{
		return $this->name;
	}

	public function team(): BedwarsTeam
	{
		return $this->team;
	}

	/**
	 * This will be called every \dev\d4y\kbedwars\game\Game tick
	 */
	abstract function tick(): bool;

}
