<?php

namespace IQ2i\PrestashopWebservice\Console\Command;

use Doctrine\Inflector\Inflector;
use Doctrine\Inflector\InflectorFactory;
use IQ2i\PrestashopWebservice\Console\Dsn;
use IQ2i\PrestashopWebservice\Generator\Generator;
use IQ2i\PrestashopWebservice\Generator\Schema;
use IQ2i\PrestashopWebservice\Http\Client;
use IQ2i\PrestashopWebservice\Http\Request\ListRequest;
use IQ2i\PrestashopWebservice\Http\Request\SchemaRequest;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateCommand extends Command
{
    protected static $defaultName = 'generate';

    public function __construct(
        private Generator $generator,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDefinition(
                [
                    new InputArgument('dsn', InputArgument::REQUIRED, 'PrestaShop API DSN.'),
                ]
            )
            ->setDescription('Generate DTOs from PrestaShop API schema.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $dsn = new Dsn($input->getArgument('dsn'));
        $client = new Client(['url' => $dsn->getUrl(), 'key' => $dsn->getKey()]);

        $response = $client->execute(new ListRequest());

        $resources = array_keys(array_filter(
            $response->getContent()['api'],
            fn(string $res) => !str_starts_with($res, '@'),
            ARRAY_FILTER_USE_KEY
        ));

        foreach ($resources as $resource) {
            $this->generator->generate($resource);
        }

        die();

        return 0;
    }

    private function getResourceSchema(Client $client, string $resourceName): Schema
    {
        $inflector = InflectorFactory::create()->build();

        $schema = new Schema($resourceName, $inflector->singularize($resourceName));

        $request = $client->execute((new SchemaRequest($resourceName))->addQueryAttribute(new Schema(Schema::SYNOPSIS)));
        $content = $request->getContent();

        return $schema;
    }
}
