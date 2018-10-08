<?php
namespace app\commands;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MigrateUpCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('migrate-up')
            ->setDescription('Creates table Location.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $statement =
<<<SQL
CREATE TABLE locations (
id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
ip varchar(15) NOT NULL UNIQUE ,
country VARCHAR(2) NOT NULL,
city VARCHAR(30) NOT NULL
)
SQL;
        try {
            $this->query($statement);
        } catch (\Exception $exception) {
            $output->writeln('Error creating table: ' . $exception->getMessage());
            return false;
        }

        $output->writeln('Table Location created successfully');
        return true;
    }
}