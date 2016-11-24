<?php

namespace TomPHP\ContextLogger;

use TomPHP\ContextLogger;

interface ContextLoggerAware
{
    /**
     * @return void
     */
    public function setLogger(ContextLogger $logger);
}
