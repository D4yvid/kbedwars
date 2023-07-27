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


namespace dev\d4y\kbedwars\database\provider;

use dev\d4y\kbedwars\database\DatabaseProvider;
use dev\d4y\kbedwars\helper\PathHelper;
use Exception;
use InvalidStateException;
use SQLite3;

class SQLiteProvider implements DatabaseProvider
{

    /** @var SQLite3 */
    private $sqlHandle;

    /**
     * @return SQLite3
     */
    public function getSqlHandle(): SQLite3
    {
        return $this->sqlHandle;
    }

    public function __construct(string $filePath)
    {
        if (!file_exists($parentDir = PathHelper::getParentDirectory($filePath)))
            @mkdir($parentDir);

        $this->sqlHandle = new SQLite3($filePath);
    }

    /**
     * @throws Exception
     */
    function connect(string $address, int $port): bool
    {
        throw new Exception("Operation not supported");
    }

    function query(string $query, array $parameters)
    {
        $stmt = $this->sqlHandle->prepare($query);

        foreach ($parameters as $k => $v) {
            $stmt->bindParam($k, $v['Value'], $this->convertType($v['Type']));
        }

        return $stmt->execute();
    }

    function execute(string $query, array $parameters = [])
    {
        $stmt = $this->sqlHandle->prepare($query);

        foreach ($parameters as $k => $v) {
            $stmt->bindParam($k, $v['Value'], $v['Type']);
        }

        $stmt->execute();
    }

    function close(): bool
    {
        return $this->sqlHandle->close();
    }

    function convertType(int $type): int
    {
        switch ($type)
        {
        case self::DATABASE_TYPE_STRING:
            return SQLITE3_TEXT;
        case self::DATABASE_TYPE_FLOAT:
            return SQLITE3_FLOAT;
        case self::DATABASE_TYPE_NUMBER:
            return SQLITE3_INTEGER;
        case self::DATABASE_TYPE_BLOB:
            return SQLITE3_BLOB;
        default:
            throw new InvalidStateException();
        }
    }
}
