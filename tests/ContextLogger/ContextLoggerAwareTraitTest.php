<?php

namespace test\TomPHP\ContextLogger;

use TomPHP\ContextLogger;
use TomPHP\ContextLogger\ContextLoggerAwareTrait;

final class ContextLoggerAwareTraitTest extends \PHPUnit_Framework_TestCase
{
    use ContextLoggerAwareTrait;

    /** @test */
    public function it_sets_the_logger_field()
    {
        $logger = $this->prophesize(ContextLogger::class)->reveal();

        $this->setLogger($logger);

        assertSame($logger, $this->logger);
    }
}
