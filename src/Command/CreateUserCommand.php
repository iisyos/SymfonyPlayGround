<?php

// src/Command/CreateUserCommand.php
namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;


#[AsCommand(name: 'app:create-user', description: 'Creates a new user.', hidden: false, aliases: ['app:add-user'])]
class CreateUserCommand extends Command
{
    public function __construct(bool $requirePassword = false)
    {
        // best practices recommend to call the parent constructor first and
        // then set your own properties. That wouldn't work in this case
        // because configure() needs the properties set in this constructor
        $this->requirePassword = $requirePassword;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Deletes rejected and spam comments from the database')
            ->addOption('dry-run', null, InputOption::VALUE_NONE, 'Dry run');
    }
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        return Command::FAILURE;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // $io = new SymfonyStyle($input, $output);
        // $io->$output->writeln([
        //     'User Creator',
        //     '============',
        //     '',
        // ]);
        // $output->writeln($this->someMethod());

        // outputs a message followed by a "\n"
        $output->writeln('Whoa!');

        // outputs a message without adding a "\n" at the end of the line
        $output->writeln('<info>You are about to </info>');
        $output->writeln('<href=https://symfony.com>Symfony Homepage</>');

        return Command::SUCCESS;
    }
}
