<?php

namespace test\TomPHP;

use Psr\Log\LoggerInterface;
use TomPHP\ContextLogger;

final class ContextLoggerTest extends \PHPUnit_Framework_TestCase
{
    private $psrLogger;

    /**
     * @var ContextLogger
     */
    private $logger;

    protected function setUp()
    {
        $this->psrLogger = $this->prophesize(LoggerInterface::class);
        $this->logger    = new ContextLogger($this->psrLogger->reveal());
    }

    /** @test */
    public function it_is_a_PSR7_logger()
    {
        assertInstanceOf(LoggerInterface::class, $this->logger);
    }

    /**
     * @test
     *
     * @dataProvider logLevels
     */
    public function the_context_can_be_set_by_the_constructor($level, $method, array $args)
    {
        $context = ['correlation_id' => uniqid(), 'user_id' => uniqid()];
        $logger  = new ContextLogger($this->psrLogger->reveal(), $context);

        array_push($args, 'Example message');
        $logger->$method(...$args);

        $this->psrLogger
            ->log($level, 'Example message', $context)
            ->shouldHaveBeenCalled();
    }

    /**
     * @test
     *
     * @dataProvider logLevels
     */
    public function on_add_context_it_adds_metadata_to_the_message($level, $method, array $args)
    {
        $correlationId = uniqid();
        $userId        = uniqid();

        $this->logger->addContext('correlation_id', $correlationId);
        $this->logger->addContext('user_id', $userId);

        array_push($args, 'Example message');
        $this->logger->$method(...$args);

        $this->psrLogger
            ->log($level, 'Example message', ['correlation_id' => $correlationId, 'user_id' => $userId])
            ->shouldHaveBeenCalled();
    }

    /**
     * @test
     *
     * @dataProvider logLevels
     */
    public function added_context_overrides_constructor_context($level, $method, array $args)
    {
        $context = ['correlation_id' => 'example-id', 'user_id' => 'old-user-id'];
        $logger  = new ContextLogger($this->psrLogger->reveal(), $context);

        $logger->addContext('user_id', 'new-user-id');

        array_push($args, 'Example message');
        $logger->$method(...$args);

        $this->psrLogger
            ->log($level, 'Example message', ['correlation_id' => 'example-id', 'user_id' => 'new-user-id'])
            ->shouldHaveBeenCalled();
    }

    /**
     * @test
     *
     * @dataProvider logLevels
     */
    public function method_context_overrides_added_context($level, $method, array $args)
    {
        $this->logger->addContext('correlation_id', 'example-id');
        $this->logger->addContext('user_id', 'old-user-id');

        array_push($args, 'Example message');
        array_push($args, ['user_id' => 'new-user-id']);
        $this->logger->$method(...$args);

        $this->psrLogger
            ->log($level, 'Example message', ['correlation_id' => 'example-id', 'user_id' => 'new-user-id'])
            ->shouldHaveBeenCalled();
    }

    /**
     * @test
     *
     * @dataProvider logLevels
     */
    public function on_removeContext_it_removes_context_by_key($level, $method, array $args)
    {
        $this->logger->addContext('correlation_id', 'example-id');
        $this->logger->addContext('user_id', 'old-user-id');

        $this->logger->removeContext('user_id');

        array_push($args, 'Example message');
        $this->logger->$method(...$args);

        $this->psrLogger
            ->log($level, 'Example message', ['correlation_id' => 'example-id'])
            ->shouldHaveBeenCalled();
    }

    public function logLevels() : array
    {
        return [
            ['emergency', 'emergency', []],
            ['alert', 'alert', []],
            ['critical', 'critical', []],
            ['error', 'error', []],
            ['warning', 'warning', []],
            ['notice', 'notice', []],
            ['info', 'info', []],
            ['debug', 'debug', []],
            ['emergency', 'log', ['emergency']],
            ['alert', 'log', ['alert']],
            ['critical', 'log', ['critical']],
            ['error', 'log', ['error']],
            ['warning', 'log', ['warning']],
            ['notice', 'log', ['notice']],
            ['info',  'log', ['info']],
            ['debug', 'log', ['debug']],
        ];
    }
}
