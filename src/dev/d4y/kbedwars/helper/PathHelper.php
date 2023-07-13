<?php

namespace dev\d4y\kbedwars\helper;

final class PathHelper
{

    public static function mount(string ...$params) {
        return str_replace(["/", "//", "\\\\"], DIRECTORY_SEPARATOR, implode("/", $params));
    }

    public static function getParentDirectory(string $path) {
        return self::mount(...array_slice(explode(DIRECTORY_SEPARATOR, $path), 0, -1));
    }

}