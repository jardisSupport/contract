<?php

declare(strict_types=1);

namespace JardisSupport\Contract\Kernel;

/**
 * Marker interface for generated Bounded Context classes.
 *
 * Deliberately empty — carries no methods. Every generated `{Domain}Context`
 * implements it, so the resolve path can recognize generated context classes
 * via `is_subclass_of($resolved, GeneratedContextInterface::class)` instead of
 * `instanceof`/base-class checks tied to a shared package base class. This
 * works across domain boundaries (cross-domain services included), which a
 * check against a common ancestor class could not guarantee once the domain
 * no longer extends a package class (Kernel-Entkopplung).
 *
 * Supersedes the detection role formerly played by
 * {@see BoundedContextInterface}, which is now `@deprecated`.
 */
interface GeneratedContextInterface
{
}
