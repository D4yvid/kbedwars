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


namespace dev\d4y\kbedwars\database\object;

use pocketmine\utils\BinaryStream;
use pocketmine\utils\UUID;

class PlayerData
{

    /** This is auto-generated when any data change. */
    private $hash;

    private $uuid;
    private $wins;
	private $gamesPlayed;
    private $kills;
    private $finalKills;
    private $bedsBroken;
    private $winStreak;
    private $level;
    private $exp;
    private $coins;

    private function __construct(
        string $uuid,
        int $wins,
		int $gamesPlayed,
        int $kills,
        int $finalKills,
        int $bedsBroken,
        int $winStreak,
        int $level,
        int $exp,
        int $coins
    ) {
        $this->uuid = $uuid;
        $this->wins = $wins;
		$this->gamesPlayed = $gamesPlayed;
        $this->kills = $kills;
        $this->finalKills = $finalKills;
        $this->bedsBroken = $bedsBroken;
        $this->winStreak = $winStreak;
        $this->level = $level;
        $this->exp = $exp;
        $this->coins = $coins;

        $this->hash = $this->hashIt();
    }

    public static function fromHash(string $hash) {
        $stream = new BinaryStream($hash);

		$uuid = $stream->getUUID()->toString();

		$wins = $stream->getLLong();
		$gamesPlayed = $stream->getLLong();

		$kills = $stream->getLLong();
		$finalKills = $stream->getLLong();

		$bedsBroken = $stream->getLLong();
		$winStreak = $stream->getLShort(false);

		$level = $stream->getLLong();
		$exp = $stream->getLInt();

		$coins = $stream->getLLong();

		return new PlayerData(
			$uuid,
			$wins,
			$gamesPlayed,
			$kills,
			$finalKills,
			$bedsBroken,
			$winStreak,
			$level,
			$exp,
			$coins
		);
    }

    public static function fromData(
        string $uuid,
        int $wins,
		int $gamesPlayed,
        int $kills,
        int $finalKills,
        int $bedsBroken,
        int $winStreak,
        int $level,
        int $exp,
        int $coins
    ): PlayerData {
        return new PlayerData(
            $uuid,
            $wins,
			$gamesPlayed,
            $kills,
            $finalKills,
            $bedsBroken,
            $winStreak,
            $level,
            $exp,
            $coins
        );
    }

    private function hashIt()
    {
        $stream = new BinaryStream();

        $stream->putUUID(UUID::fromString($this->uuid));
        $stream->putLInt($this->wins);
        $stream->putInt($this->kills);
        $stream->putLInt($this->finalKills);
        $stream->putInt($this->bedsBroken);
        $stream->putLInt($this->winStreak);
        $stream->putInt($this->level);
        $stream->putLInt($this->exp);
        $stream->putInt($this->coins);

        return "";
    }

}
