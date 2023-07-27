<?php

namespace dev\d4y\kbedwars\game;

use dev\d4y\kbedwars\game\event\GeneratorUpgradeEvent;
use pocketmine\level\Level;
use pocketmine\Player;
use pocketmine\utils\UUID;

class Game
{

    const GAMEMODE_SOLO  = 0b0001;
    const GAMEMODE_DUO   = 0b0010;
    const GAMEMODE_TRIO  = 0b0100;
    const GAMEMODE_SQUAD = 0b1000;

	/** @var UUID */
	private $id;

	/** @var GameEvent[] */
	private $events = [
		GeneratorUpgradeEvent::new(GeneratorUpgradeEvent::DIAMOND_GENERATOR, 1),
		GeneratorUpgradeEvent::new(GeneratorUpgradeEvent::EMERALD_GENERATOR, 1),
		GeneratorUpgradeEvent::new(GeneratorUpgradeEvent::DIAMOND_GENERATOR, 2),
		GeneratorUpgradeEvent::new(GeneratorUpgradeEvent::EMERALD_GENERATOR, 2),
		GeneratorUpgradeEvent::new(GeneratorUpgradeEvent::DIAMOND_GENERATOR, 3),
		GeneratorUpgradeEvent::new(GeneratorUpgradeEvent::EMERALD_GENERATOR, 3)
	];

	/** @var BedwarsTeam[] */
	private $teams;

	/** @var Player[] */
	private $players;

	/** @var int */
	private $mode;

    /** @var Level */
    private $level;

    public function __construct(UUID $id, Level $level, array $teams, int $mode = self::GAMEMODE_SOLO)
    {
		$this->id = $id;
		$this->teams = $teams;
		$this->mode = $mode;
		$this->level = $level;
		$this->players = [];
    }

	/**
	 * @return GameEvent|null
	 */
	public function getNextEvent()
	{
		return $this->events[0];
	}

    /**
     * @return Level
     */
    public function getLevel(): Level
    {
        return $this->level;
    }

    /**
     * @return UUID
     */
    public function getId(): UUID
    {
        return $this->id;
    }

    /**
     * @return GameEvent[]
     */
    public function getEvents(): array
    {
        return $this->events;
    }

    /**
     * @return BedwarsTeam[]
     */
    public function getTeams(): array
    {
        return $this->teams;
    }

    /**
     * @return Player[]
     */
    public function getPlayers(): array
    {
        return $this->players;
    }

    /**
     * @return int
     */
    public function getMode(): int
    {
        return $this->mode;
    }

}
