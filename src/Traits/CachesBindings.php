<?php

declare(strict_types=1);

namespace MichaelRubel\AutoBinder\Traits;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

trait CachesBindings
{
    /**
     * Use the bindings from the cache.
     *
     * @return void
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    protected function fromCache(): void
    {
        collect(cache()->get($this->cacheClue()))->each(
            fn ($concrete, $interface) => app()->{$this->bindingType}($interface, $concrete)
        );
    }

    /**
     * Cache the binding.
     *
     * @param  string  $interface
     * @param  \Closure|string  $concrete
     *
     * @return void
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    protected function cacheBindingFor(string $interface, \Closure|string $concrete): void
    {
        $clue = $this->cacheClue();

        $cache = cache()->get($clue);

        $cache[$interface] = $concrete;

        cache()->put($clue, $cache);
    }
}
