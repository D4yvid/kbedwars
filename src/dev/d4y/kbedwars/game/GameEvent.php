<?php

namespace dev\d4y\kbedwars\game;

use pocketmine\utils\UUID;

abstract class GameEvent
{

	/** @var UUID */
	private $id;

	/** @var string */
	private $name;

	/** @var int */
	private $delay;

	/** @var bool */
	private $finished;

	public function __construct(UUID $id, string $name, string $delay)
	{
		$this->id = $id;
		$this->name = $name;
		$this->delay = $delay;
	}

	public function id(): UUID
	{
		return $this->id;
	}

	public function name(): string
	{
		return $this->name;
	}

	public function delay(): int
	{
		return $this->delay;
	}

	public function setDelay(int $newDelay)
	{
		$this->delay = $newDelay;
	}

	public function finished()
	{
		return $this->finished;
	}

	public function finish()
	{
		$this->finished = $this->execute();
	}

	/**
	 * This will be called every \dev\d4y\kbedwars\game\Game tick
	 */
	abstract function tick(): bool;

	/**
	 * This will be called when the timer finish
	 */
	abstract function execute(): bool;

}

