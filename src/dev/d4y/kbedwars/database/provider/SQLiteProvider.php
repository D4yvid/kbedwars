<?php

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