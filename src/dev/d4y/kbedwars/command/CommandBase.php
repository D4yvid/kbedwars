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
use pocketmine\command\Command;
use pocketmine\command\CommandExecutor;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\TextFormat;

abstract class CommandBase implements CommandExecutor
{

	/** @var Entry */
	private $plugin;

	/** @var string */
	private $name;

	/** @var string|null */
	private $permission;

	/** @var bool */
	private $player_only;

	/** @var array */
	private $subcommands;

	/**
	 * @param string|null $permission
	 */
	public function __construct(
		Entry $plugin,
		string $name,
		$permission,
		bool $player_only,
		array $subcommands
	) {
		$this->plugin = $plugin;

		$this->name = $name;
		$this->permission = $permission;
		$this->player_only = $player_only;
		$this->subcommands = $subcommands;
	}

	public abstract function execute(CommandSender $sender, array $args);

	public function getPlugin(): Entry
	{
		return $this->plugin;
	}

	public function getName(): string
	{
		return $this->name;
	}

	/** @return string|null */
	public function getPermission()
	{
		return $this->permission;
	}

	public function getSubcommands(): array
	{
		return $this->subcommands;
	}

	public function onCommand(CommandSender $sender, Command $command, $label, array $args)
	{
		if (!empty($this->permission) && !$sender->hasPermission($this->permission))
		{
			$sender->sendMessage(TextFormat::RED . "You don't have permission to use this command!");
			return;
		}

		if (!($sender instanceof Player) && $this->player_only)
		{
			$sender->sendMessage(TextFormat::RED . "You need to use this command in-game!");
			return;
		}

		if (sizeof($args) > 0)
		{
			$subcommand_name = $args[0];
			$subcommand = array_filter(
				$this->subcommands,

				function ($subcommand, $key) use ($subcommand_name) {
					return $key == $subcommand_name || $subcommand->isAlias($subcommand_name);
				},

				ARRAY_FILTER_USE_BOTH
			);

			$subcommand = array_shift($subcommand);

			if ($subcommand)
			{
				/** @var SubcommandBase $subcommand */
				$subcommand->onCommand($sender, $command, $subcommand_name, array_slice($args, 1));
				return;
			}
		}

		$this->execute($sender, $args);
	}

	public function getCommandSlashString(): string
    {
		$data = $this->getName();

		return "/$data";
	}

	public static function sendErrorMessage(Player $player, string $msg) {
		$player->sendMessage(TextFormat::RESET . TextFormat::RED . $msg);
	}


}
