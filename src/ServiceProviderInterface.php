<?php

namespace Zidoc;

/**
 * Interface ServiceProviderInterface
 */
interface ServiceProviderInterface
{
    /**
     * @param Container $container
     */
    public function register(Container $container): void;
}
