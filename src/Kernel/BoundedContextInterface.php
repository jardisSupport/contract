<?php

declare(strict_types=1);

namespace JardisSupport\Contract\Kernel;

use Throwable;

/**
 * Bounded Context interface for handling domain use cases.
 */
interface BoundedContextInterface
{
    /**
     * @template T
     * @param class-string<T> $className
     * @return T|null
     * @throws Throwable
     */
    public function handle(string $className, mixed ...$parameters): mixed;
}
