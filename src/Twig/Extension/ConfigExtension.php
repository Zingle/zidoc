<?php

namespace Zidoc\Twig\Extension;

use Zidoc\Core\Config;

/**
 * Class ConfigExtension
 */
class ConfigExtension extends \Twig_Extension implements \Twig_Extension_GlobalsInterface
{
    /**
     * @var Config
     */
    private $config;


    /**
     * ConfigExtension constructor.
     *
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * @return array
     */
    public function getGlobals()
    {
        return [
            'config' => $this->config,
        ];
    }
}
