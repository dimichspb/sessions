<?php
namespace app\commands;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MigrateDownCommand extends Command
{
    /**
     * Migrate Up command configuration
     */
    protected function configure()
    {
        $this
            ->setName('migrate-down')
            ->setDescription('Drops table Location.');
    }

    /**
     * Migrate Up command executive
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return bool|int|null
     */
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