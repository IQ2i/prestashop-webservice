<?php

namespace IQ2i\PrestashopWebservice\Console;

use IQ2i\PrestashopWebservice\Console\Command\GenerateCommand;
use Symfony\Component\Console\Application as BaseApplication;
use Symfony\Component\Console\Command\HelpCommand;
use Symfony\Component\Console\Command\ListCommand;

class Application extends BaseApplication
{
    public function __construct()
    {
        parent::__construct('PrestaShop Webservice DTO Generator');

        $this->add(new GenerateCommand());
    }

    protected function getDefaultCommands(): array
    {
        return [new HelpCommand(), new ListCommand()];
    }
}
