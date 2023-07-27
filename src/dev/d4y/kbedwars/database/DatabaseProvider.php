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


namespace dev\d4y\kbedwars\database;

interface DatabaseProvider
{

    const SQLITE3 = 'sqlite';
    const MYSQL = 'mysql';

    const DATABASE_TYPE_STRING = 1;
    const DATABASE_TYPE_NUMBER = 2;
    const DATABASE_TYPE_FLOAT = 3;
    const DATABASE_TYPE_BLOB = 4;

    function connect(string $address, int $port): bool;

    function query(string $query, array $parameters);
    function execute(string $query, array $parameters = []);

    function close(): bool;

    function convertType(int $type);

}
