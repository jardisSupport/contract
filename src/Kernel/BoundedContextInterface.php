<?php

declare(strict_types=1);

namespace JardisSupport\Contract\Kernel;

use Throwable;

/**
 * Bounded Context interface for handling domain use cases.
 *
 * Two entry points for class resolution:
 *   - handle()  pass-through, inherits the caller's payload+version
 *   - context() fresh context, sets payload+version explicitly
 *               (used at API boundaries to start a new call chain)
 */
interface BoundedContextInterface
{
    /**
     * Resolves and instantiates a class while inheriting the current
     * payload+version from this BoundedContext.
     *
     * @template T
     * @param class-string<T> $className
     * @return T|null
     * @throws Throwable
     */
    public function handle(string $className, mixed ...$parameters): mixed;

    /**
     * Starts a fresh context for the given BoundedContext subclass,
     * setting payload+version explicitly. The kernel is inherited.
     *
     * Implementations must reject non-BoundedContext targets, since
     * payload+version are meaningless for plain services.
     *
     * @template T of BoundedContextInterface
     * @param class-string<T> $className
     * @return T
     * @throws Throwable
     */
    public function context(string $className, mixed $payload, string $version = ''): mixed;
}
