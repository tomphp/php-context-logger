<?php

namespace TomPHP\ContextLogger;

use TomPHP\ContextLogger;

trait ContextLoggerAwareTrait
{
    /**
     * @var ContextLogger
     */
    protected $logger;

    public function setLogger(ContextLogger $logger)
    {
        $this->logger = $logger;
    }
}
