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
use Exception;
use InvalidArgumentException;
use mysqli;
use RuntimeException;

class MySQLProvider implements DatabaseProvider
{

    /** @var mysqli */
    private $mysqlHandle;

    /** @var bool */
    private $connected;

    /** @var bool */
    private $valid;

    /** @var string */
    private $username;

    /** @var string */
    private $password;

    /** @var string */
    private $database;

    public function __construct(string $database, string $username = "", string $password = "")
    {
        $this->mysqlHandle = new mysqli();
        $this->valid = false;

        $this->username = $username;
        $this->password = $password;
        $this->database = $database;
    }

    function connect(string $address, int $port): bool
    {
        if ($this->connected)
        {
            throw new RuntimeException("This instance is already connected");
        }

        try {
            $this->getMySQLHandle()->connect(
                $address,
                $this->getUsername(),
                $this->getPassword(),
                $this->getDatabase(),
                $port
            );
        } catch (Exception $exception) {
            $this->valid = false;

            throw new RuntimeException("Could not connect to the database: ", 1, $exception);
        }

        $this->connected = true;
        $this->valid = true;

        return true;
    }

    function query(string $query, array $parameters)
    {
        $stmt = $this->getMySQLHandle()->prepare($query);

        foreach ($parameters as $value) {
            $stmt->bind_param($this->convertType($value['Type']), $value['Value']);
        }

        if (!$stmt->execute())
        {
            return null;
        }

        return $stmt->get_result();
    }

    function execute(string $query, array $parameters = []): bool
    {
        $stmt = $this->getMySQLHandle()->prepare($query);

        foreach ($parameters as $value) {
            $stmt->bind_param($this->convertType($value['Type']), $value['Value']);
        }

        if (!$stmt->execute())
            return false;

        return true;
    }

    function close(): bool
    {
        if (!$this->valid)
            return false;

        return $this->getMySQLHandle()->close();
    }

    /**
     * @return bool
     */
    public function isConnected(): bool
    {
        return $this->connected;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getDatabase(): string
    {
        return $this->database;
    }

    /**
     * @return mysqli
     */
    public function getMySQLHandle(): mysqli
    {
        return $this->mysqlHandle;
    }

    function convertType(int $type): string
    {
        switch ($type)
        {
        case self::DATABASE_TYPE_STRING:
            return 's';
        case self::DATABASE_TYPE_NUMBER:
            return 'i';
        case self::DATABASE_TYPE_FLOAT:
            return 'f';
        case self::DATABASE_TYPE_BLOB:
            return 'b';
        default:
            throw new InvalidArgumentException();
        }
    }
}
