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

use pocketmine\math\Vector3;

class BedwarsTeam
{

    const COLOR_RED = 0x0;
    const COLOR_YELLOW = 0x1;
    const COLOR_GREEN = 0x2;
    const COLOR_AQUA = 0x3;
    const COLOR_BLUE = 0x4;
    const COLOR_PINK = 0x5;
    const COLOR_MAGENTA = 0x6;
    const COLOR_WHITE = 0x7;
    const COLOR_BLACK = 0x8;
    const COLOR_GRAY = 0x9;
    const COLOR_ORANGE = 0xA;
    const COLOR_BROWN = 0xB;

    private $color;

    private $players;
    private $upgrades;

    /** @var array<Vector3> */
    private $bedPosition;

    /** @var bool */
    private $bedBroken;

    /**
     * @param int $color
     * @param array<Vector3> $bedPosition
     * @param array $players
     * @param array $upgrades
     */
    public function __construct(
        int $color,
        array $bedPosition,
        bool $bedBroken = false,
        array $players = [],
        array $upgrades = []
    ) {
        $this->color = $color;
        $this->bedPosition = $bedPosition;
        $this->bedBroken = $bedBroken;

        $this->players = $players;
        $this->upgrades = $upgrades;
    }

    /**
     * @return bool
     */
    public function isBedBroken(): bool
    {
        return $this->bedBroken;
    }

    /**
     * @param bool $bedBroken
     */
    public function setBedBroken(bool $bedBroken)
    {
        $this->bedBroken = $bedBroken;
    }

    /**
     * @return int
     */
    public function getColor(): int
    {
        return $this->color;
    }

    /**
     * @return array
     */
    public function getPlayers(): array
    {
        return $this->players;
    }

    /**
     * @return array
     */
    public function getUpgrades(): array
    {
        return $this->upgrades;
    }

    /**
     * @return Vector3[]
     */
    public function getBedPosition(): array
    {
        return $this->bedPosition;
    }

}
