<?php

return [
    'name'   => 'Zidoc',
    'theme'  => 'default',
    'source' => 'source',
    'output' => 'output',
    'commands' => [
        Zidoc\Play\PlayCommand::class,
        Zidoc\Generator\GenerateCommand::class,
    ],
    'parsers' => [
        Zidoc\CommonMark\Parser::class,
        Zidoc\Twig\Parser::class,
    ],
    'providers' => [
        new Zidoc\CommonMark\CommonMarkServiceProvider(),
        new Zidoc\Core\CoreServiceProvider(),
        new Zidoc\Generator\GeneratorServiceProvider(),
        new Zidoc\Parser\ParserServiceProvider(),
        new Zidoc\Play\PlayServiceProvider(),
        new Zidoc\Template\TemplateServiceProvider(),
        new Zidoc\Twig\TwigServiceProvider(),
    ],
    'templatesDir' => 'templates',
];
