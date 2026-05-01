<?php

declare(strict_types=1);

namespace JardisSupport\Contract\Workflow;

use Exception;

/**
 * Workflow interface for orchestrating multi-step processes.
 *
 * Executes a series of configured workflow nodes with conditional branching.
 * Handler instantiation is an implementation detail (factory, container, or direct).
 *
 * Each handler is invoked with the original $parameters plus a WorkflowContextInterface
 * as the last argument. The handler returns a WorkflowResultInterface which is appended
 * to the context. The same context is returned to the caller after the workflow
 * terminates and exposes both the final result (getPrevious()) and the full
 * execution chain (getChain()).
 */
interface WorkflowInterface
{
    /**
     * Executes the workflow with the given configuration and parameters.
     *
     * @param WorkflowConfigInterface $workflowConfig The workflow configuration with nodes
     * @param mixed ...$parameters Parameters passed ahead of the context to each handler
     *                             (e.g., subject, request, user)
     * @return WorkflowContextInterface The execution context with the full result chain
     * @throws Exception If workflow execution fails
     */
    public function __invoke(
        WorkflowConfigInterface $workflowConfig,
        mixed ...$parameters
    ): WorkflowContextInterface;
}
