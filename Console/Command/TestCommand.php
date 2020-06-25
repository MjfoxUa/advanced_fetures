<?php
/**
 * Plumrocket Inc.
 * NOTICE OF LICENSE
 * This source file is subject to the End-user License Agreement
 * that is available through the world-wide-web at this URL:
 * http://wiki.plumrocket.net/wiki/EULA
 * If you are unable to obtain it through the world-wide-web, please
 * send an email to support@plumrocket.com so we can send you a copy immediately.
 *
 * @package     Plumrocket magento
 * @copyright   Copyright (c) 2020 Plumrocket Inc. (http://www.plumrocket.com)
 * @license     http://wiki.plumrocket.net/wiki/EULA  End-user License Agreement
 */

namespace Mjfox\Education\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class TestCommand extends Command
{
    const INFO = 'info';

    protected function configure()
    {
        $this->setName('imagine:dragon');
        $this->setDescription('Imagine Dragon console command.');
        $this->addOption(
            self::INFO,
            null,
            InputOption::VALUE_REQUIRED,
            'Imagine Dragon Info'
        );

        parent::configure();
    }

    /**
     * Execute the command
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return null|int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ($test = $input->getOption(self::INFO)) {
            $output->writeln(
                '<info>Imagine Dragons is an American rock band from Las Vegas, Nevada. Test command:`' . $test . '`</info>'
            );

        }

        $output->writeln('<info>Test Success Message.</info>');
        $output->writeln('<error>Test error encountered.</error>');
        $output->writeln('<comment>Test Some Comment.</comment>');
    }
}

