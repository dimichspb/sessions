<?php
namespace app\commands;

abstract class Command extends \Symfony\Component\Console\Command\Command
{
    /**
     * @var \mysqli
     */
    protected $connection;

    /**
     * Command constructor.
     * @param \mysqli $connection
     */
    public function __construct(\mysqli $connection)
    {
        $this->connection = $connection;
        if ($this->connection->connect_error) {
            throw new \RuntimeException('Connection error: ' . $this->connection->connect_error);
        }
        parent::__construct();
    }

    /**
     * Query the statement
     * @param $statement
     * @return bool|\mysqli_result
     */
    public function query($statement)
    {
        if (!$result = $this->connection->query($statement)) {
            throw new \RuntimeException('Query error: ' . $this->connection->error);
        }

        return $result;
    }
}