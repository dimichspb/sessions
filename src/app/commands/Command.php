<?php
namespace app\commands;

abstract class Command extends \Symfony\Component\Console\Command\Command
{
    protected $connection;

    public function __construct(\mysqli $connection)
    {
        $this->connection = $connection;
        if ($this->connection->connect_error) {
            throw new \RuntimeException('Connection error: ' . $this->connection->connect_error);
        }
        parent::__construct();
    }

    public function query($statement)
    {
        if (!$result = $this->connection->query($statement)) {
            throw new \RuntimeException('Query error: ' . $this->connection->error);
        }

        return $result;
    }
}