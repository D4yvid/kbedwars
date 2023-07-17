<?php

namespace dev\d4y\kbedwars\database\object;

use pocketmine\utils\BinaryStream;
use pocketmine\utils\UUID;

class PlayerData
{

    /** This is auto-generated when any data change. */
    private $hash;

    private $uuid;
    private $wins;
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

        

        return new PlayerData();
    }

    public static function fromData(
        string $uuid,
        int $wins,
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
