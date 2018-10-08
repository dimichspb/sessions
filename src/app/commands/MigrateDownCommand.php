<?php
namespace app\commands;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MigrateDownCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('migrate-down')
            ->setDescription('Drops table Location.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $statement =
<<<SQL
DROP TABLE IF EXISTS locations;
SQL;
        try {
            $this->query($statement);
        } catch (\Exception $exception) {
            $output->writeln('Error dropping table: ' . $exception->getMessage());
        }

        $output->writeln('Table Location dropped successfully');
        return true;
    }
}