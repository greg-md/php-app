<?php

namespace App\ServiceProviders\App\Commands;

use App\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UninstallCommand extends Command
{
    private $app;

    public function __construct(Application $app)
    {
        $this->app = $app;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('uninstall')
            ->addArgument('package', InputArgument::REQUIRED, 'The name of the Service Provider.')
            ->setDescription('Uninstall Service Provider.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $package = $input->getArgument('package');

        $serviceProvider = $this->app->getServiceProvider($package);

        $this->app->ioc()->call([$serviceProvider, 'uninstall'], $input, $output);

        $message = 'Package <fg=yellow;options=bold>' . $package . '</> has been uninstalled.';

        $output->writeln('<info>' . $message . '</info>');
    }
}
