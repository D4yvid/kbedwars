<?php

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

	public function getCommandSlashString()
	{
		$data = $this->getName();

		return "/$data";
	}

	public static function sendErrorMessage(Player $player, string $msg) {
		$player->sendMessage(TextFormat::RESET . TextFormat::RED . $msg);
	}


}
