<?php

namespace dev\d4y\kbedwars\helper;

use dev\d4y\kbedwars\Entry;

final class Log
{

    private function __construct()
    {
        assert(false, "how?");
    }

    public static function info(string $fmt, ...$args)
    {
        Entry::get()->getLogger()->info(sprintf($fmt, ...$args));
    }

    public static function warn(string $fmt, ...$args)
    {
        Entry::get()->getLogger()->warning(sprintf($fmt, ...$args));
    }

    public static function error(string $fmt, ...$args)
    {
        Entry::get()->getLogger()->error(sprintf($fmt, ...$args));
    }

    public static function notice(string $fmt, ...$args)
    {
        Entry::get()->getLogger()->notice(sprintf($fmt, ...$args));
    }

}