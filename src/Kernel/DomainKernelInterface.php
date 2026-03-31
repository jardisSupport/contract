<?php

declare(strict_types=1);

namespace JardisSupport\Contract\Kernel;

use PDO;
use Psr\Container\ContainerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\CacheInterface;

/**
 * Domain infrastructure interface.
 *
 * Provides typed, immutable access to infrastructure services for bounded contexts.
 * All service interfaces are PSR standards or PHP quasi-standards (PDO).
 * Set once at bootstrap via constructor injection, immutable after creation.
 *
 * Services are nullable — not every project needs every service.
 * The domain code checks availability and acts accordingly.
 */
interface DomainKernelInterface
{
    /**
     * Gets the application root directory path.
     *
     * @return string Absolute path to the application root (where composer.json lives)
     */
    public function appRoot(): string;

    /**
     * Gets the domain root directory path.
     *
     * @return string Absolute path to the domain root (where the domain code lives)
     */
    public function domainRoot(): string;

    /**
     * Gets environment configuration value(s).
     *
     * @param string|null $key Optional key to retrieve specific config value
     * @return mixed|array<string, mixed> Single value if key provided, all config if null
     */
    public function env(?string $key = null): mixed;

    /**
     * Gets the PSR-11 service container.
     *
     * Used by BoundedContext for class resolution and service lookup.
     * Optional services (ClassVersion, Messaging, ConnectionPool, etc.)
     * are accessed through the container.
     *
     * @return ContainerInterface Container instance (always available)
     */
    public function container(): ContainerInterface;

    /**
     * Gets the PSR-16 simple cache.
     *
     * @return CacheInterface|null Cache instance or null if not configured
     */
    public function cache(): ?CacheInterface;

    /**
     * Gets the PSR-3 logger.
     *
     * @return LoggerInterface|null Logger instance or null if not configured
     */
    public function logger(): ?LoggerInterface;

    /**
     * Gets the PSR-14 event dispatcher for domain events.
     *
     * @return EventDispatcherInterface|null Dispatcher or null if not configured
     */
    public function eventDispatcher(): ?EventDispatcherInterface;

    /**
     * Gets the PSR-18 HTTP client for external service calls.
     *
     * @return ClientInterface|null HTTP client or null if not configured
     */
    public function httpClient(): ?ClientInterface;

    /**
     * Gets the PDO connection for write operations.
     *
     * @return PDO|null Writer PDO or null if no database configured
     */
    public function dbWriter(): ?PDO;

    /**
     * Gets the PDO connection for read operations.
     *
     * Returns a read replica if configured, otherwise falls back to the writer.
     * Implementation may provide load balancing across multiple readers.
     *
     * @return PDO|null Reader PDO or null if no database configured
     */
    public function dbReader(): ?PDO;
}
