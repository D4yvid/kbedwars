<?php

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
