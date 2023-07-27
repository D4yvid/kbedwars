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


namespace dev\d4y\kbedwars\helper;

use pocketmine\plugin\PluginBase;

final class Log
{

    /** @var PluginBase */
    private static $plugin;

    private function __construct()
    {
        assert(false, "how?");
    }

    public static function init(PluginBase $plugin)
    {
        self::$plugin = $plugin;
    }

    public static function info(string $fmt, ...$args)
    {
        self::$plugin->getLogger()->info(sprintf($fmt, ...$args));
    }

    public static function warn(string $fmt, ...$args)
    {
        self::$plugin->getLogger()->warning(sprintf($fmt, ...$args));
    }

    public static function error(string $fmt, ...$args)
    {
        self::$plugin->getLogger()->error(sprintf($fmt, ...$args));
    }

    public static function notice(string $fmt, ...$args)
    {
        self::$plugin->getLogger()->notice(sprintf($fmt, ...$args));
    }

}
