<?php

namespace dev\d4y\kbedwars\database\provider;

use dev\d4y\kbedwars\database\DatabaseProvider;
use Exception;
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
            throw new RuntimeException("Could not connect to the database: ", $exception);
        }
    }

    function query(string $query, array $parameters)
    {
        // TODO: Implement query() method.
    }

    function execute(string $query, array $parameters)
    {
        // TODO: Implement execute() method.
    }

    function close(): bool
    {
        // TODO: Implement close() method.
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

}