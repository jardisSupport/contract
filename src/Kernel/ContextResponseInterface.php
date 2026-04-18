<?php

declare(strict_types=1);

namespace JardisSupport\Contract\Kernel;

/**
 * Interface for Context Response objects.
 *
 * Defines the contract for transporting results through bounded context chains.
 * All getter methods return context-keyed arrays for traceability.
 */
interface ContextResponseInterface
{
    /**
     * Add a single data entry.
     */
    public function addData(string $key, mixed $value): self;

    /**
     * Set all data at once (replaces existing data).
     *
     * @param array<string, mixed> $data
     */
    public function setData(array $data): self;

    /**
     * Get data from this result, keyed by context name.
     *
     * @return array<string, array<string, mixed>>
     */
    public function getData(): array;

    /**
     * Add a domain event.
     */
    public function addEvent(object $event): self;

    /**
     * Get events from this result, keyed by context name.
     *
     * @return array<string, array<int, object>>
     */
    public function getEvents(): array;

    /**
     * Add an error message.
     */
    public function addError(string $message): self;

    /**
     * Get errors from this result, keyed by context name.
     *
     * @return array<string, array<int, string>>
     */
    public function getErrors(): array;

    /**
     * Add a sub-result from a nested BC call.
     */
    public function addResult(ContextResponseInterface $result): self;

    /**
     * Get direct sub-results.
     *
     * @return array<int, ContextResponseInterface>
     */
    public function getResults(): array;
}
