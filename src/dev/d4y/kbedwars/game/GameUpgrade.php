<?php

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
