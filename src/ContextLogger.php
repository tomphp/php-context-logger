<?php

namespace TomPHP;

use Psr\Log\LoggerInterface;

class ContextLogger implements LoggerInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var array
     */
    private $context;

    public function __construct(LoggerInterface $logger, array $context = [])
    {
        $this->logger  = $logger;
        $this->context = $context;
    }

    /**
     * @param string $name
     * @param mixed  $value
     *
     * @return void
     */
    public function addContext($name, $value)
    {
        $this->context[$name] = $value;
    }

    /**
     * @param string $name
     *
     * @return void
     */
    public function removeContext($name)
    {
        unset($this->context[$name]);
    }

    public function emergency($message, array $context = [])
    {
        $this->log('emergency', $message, $context);
    }

    public function alert($message, array $context = [])
    {
        $this->log('alert', $message, $context);
    }

    public function critical($message, array $context = [])
    {
        $this->log('critical', $message, $context);
    }

    public function error($message, array $context = [])
    {
        $this->log('error', $message, $context);
    }

    public function warning($message, array $context = [])
    {
        $this->log('warning', $message, $context);
    }

    public function notice($message, array $context = [])
    {
        $this->log('notice', $message, $context);
    }

    public function info($message, array $context = [])
    {
        $this->log('info', $message, $context);
    }

    public function debug($message, array $context = [])
    {
        $this->log('debug', $message, $context);
    }

    public function log($level, $message, array $context = [])
    {
        $this->logger->log($level, $message, array_merge($this->context, $context));
    }
}
