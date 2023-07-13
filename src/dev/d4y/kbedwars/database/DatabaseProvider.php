<?php

namespace dev\d4y\kbedwars\database;

interface DatabaseProvider
{

    const SQLITE3 = 'sqlite';
    const MYSQL = 'mysql';

    function connect(string $address, int $port): bool;

    function query(string $query, array $parameters);
    function execute(string $query, array $parameters);

    function close(): bool;

}