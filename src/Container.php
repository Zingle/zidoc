<?php

namespace Zidoc;

/**
 * Class Container
 */
class Container extends \Pimple\Container
{
    /**
     * @param string   $key
     * @param \Closure $factory
     *
     * @return Container
     */
    public function bind(string $key, \Closure $factory): Container
    {
        $this[$key] = $factory;

        return $this;
    }

    /**
     * @param string $key
     * @param mixed  $value
     *
     * @return Container
     */
    public function instance(string $key, $value): Container
    {
        $this[$key] = $value;

        return $this;
    }

    /**
     * @param string   $key
     * @param \Closure $factory
     *
     * @return Container
     */
    public function serviceFactory(string $key, \Closure $factory): Container
    {
        $this[$key] = $this->factory($factory);

        return $this;
    }

    /**
     * @param string $key
     *
     * @return mixed
     */
    public function make(string $key)
    {
        if ($this->offsetExists($key)) {
            return $this->offsetGet($key);
        }

        if (!class_exists($key)) {
            throw new \RuntimeException(sprintf('Unrecognized class "%s"', $key));
        }

        try {
            $reflection = new \ReflectionClass($key);

            $constructor = $reflection->getConstructor();
            $arguments   = $constructor ? array_map(function (\ReflectionParameter $parameter) {
                $type = $parameter->getType();
                if (!$type instanceof \ReflectionNamedType) {
                    throw new \RuntimeException('Unable to infer type');
                }

                return $this->make($type->getName());
            }, $constructor->getParameters()) : [];

            return $reflection->newInstance(...$arguments);
        } catch (\ReflectionException $e) {
            throw new \RuntimeException(sprintf('Unable to build class "%s"', $key));
        }
    }

    /**
     * @param ServiceProviderInterface $provider
     *
     * @return Container
     */
    public function registerProvider(ServiceProviderInterface $provider): Container
    {
        $provider->register($this);

        return $this;
    }
}
