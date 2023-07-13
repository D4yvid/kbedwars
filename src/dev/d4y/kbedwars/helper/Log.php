<?php

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
