<?php

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