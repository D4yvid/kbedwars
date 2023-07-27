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


namespace dev\d4y\kbedwars\command;

use dev\d4y\kbedwars\Entry;
use pocketmine\command\CommandSender;

abstract class SubcommandBase extends CommandBase
{

	/** @var CommandBase */
	private $owner;

	/** @var array */
	private $aliases;

	public function __construct(
		Entry $plugin,
		CommandBase $owner,
		string $name,
		string $description,
		bool $player_only,
		array $aliases,
		array $subcommands
	) {
		$this->owner = $owner;
		$this->aliases = $aliases;

		parent::__construct($plugin, $name, $description, $player_only, $subcommands);
	}

	public function getAliases(): array
	{
		return $this->aliases;
	}

	public function getOwner(): CommandBase
	{
		return $this->owner;
	}

	public function isAlias(string $name): bool
	{
		return in_array($name, $this->aliases);
	}

	public function getCommandSlashString()
	{
		return "{$this->getOwner()->getCommandSlashString()} {$this->getName()}";
	}

}
