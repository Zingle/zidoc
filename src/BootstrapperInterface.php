<?php

namespace Zidoc;

/**
 * Interface BootstrapperInterface
 */
interface BootstrapperInterface
{
    /**
     * @param Container $container
     */
    public function boot(Container $container): void;
}
