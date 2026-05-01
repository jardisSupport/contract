<?php

declare(strict_types=1);

namespace JardisSupport\Contract\Workflow;

/**
 * Interface for the execution context passed through a workflow's handler chain.
 *
 * Carries the full ordered execution log of a workflow run. Every invocation of a
 * handler appends a new entry — even when the same handler is reached multiple
 * times via different branches or retry loops — so no result is ever lost.
 *
 * Lookups by handler FQCN return either the most recent invocation
 * (getLatest()) or every invocation in execution order (getAll()).
 *
 * Replaces the prior $result/$callStack tuple returned by Workflow::__invoke().
 */
interface WorkflowContextInterface
{
    /**
     * Appends a handler result to the chain and marks it as the previous result.
     * Repeat invocations of the same handler do NOT overwrite earlier entries —
     * each call adds a new entry to the ordered execution log.
     *
     * @param class-string $handlerFqcn The fully-qualified handler class name
     * @param WorkflowResultInterface $result The result returned by that handler
     */
    public function append(string $handlerFqcn, WorkflowResultInterface $result): void;

    /**
     * Returns the most recently appended result — the immediate predecessor's result
     * for the handler currently being invoked. Null before any handler has run.
     */
    public function getPrevious(): ?WorkflowResultInterface;

    /**
     * Returns the most recent result of a specific handler, or null if that handler
     * has not been invoked.
     *
     * @param class-string $handlerFqcn
     */
    public function getLatest(string $handlerFqcn): ?WorkflowResultInterface;

    /**
     * Returns every result produced by a specific handler in execution order.
     * Empty list if the handler has not been invoked.
     *
     * @param class-string $handlerFqcn
     * @return list<WorkflowResultInterface>
     */
    public function getAll(string $handlerFqcn): array;

    /**
     * Returns the full execution chain in order. Each entry pairs the handler FQCN
     * with the result it produced; the same handler may appear multiple times.
     *
     * @return list<array{handler: class-string, result: WorkflowResultInterface}>
     */
    public function getChain(): array;
}
