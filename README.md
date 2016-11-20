# Context Logger

[![Build Status](https://travis-ci.org/tomphp/php-context-logger.svg?branch=master)](https://travis-ci.org/tomphp/php-context-logger)
[![Latest Stable Version](https://poser.pugx.org/tomphp/context-logger/v/stable)](https://packagist.org/packages/tomphp/context-logger)
[![Total Downloads](https://poser.pugx.org/tomphp/context-logger/downloads)](https://packagist.org/packages/tomphp/context-logger)
[![Latest Unstable Version](https://poser.pugx.org/tomphp/context-logger/v/unstable)](https://packagist.org/packages/tomphp/context-logger)
[![License](https://poser.pugx.org/tomphp/context-logger/license)](https://packagist.org/packages/tomphp/context-logger)

A PSR-3 compliant logger decorator which allows context metadata to be built up.

## Installation

```
$ composer require tomphp/context-logger
```

## Usage

```php
<?php

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use TomPHP\ContextLogger;

$monolog = new Logger('name');
$monolog->pushHandler(new StreamHandler('path/to/your.log', Logger::WARNING));

$log = new ContextLogger($monolog);

$log->addContext('correlation_id', uniqid());

$log->error('There was an error');
```

### Setting the Context

An original context can be set by providing an array as the second argument to
the constructor:

```php
$log = new ContextLogger($monolog, ['correlation_id' => uniqid()]);
```

The context can be added to or modified by the
`addContext(string $name, $value)` method.

The context can also be added to/modified by providing an array to the
`$context` parameter of any of the PSR-7 `LoggerInterface` methods.

### Removing Context

You can remove a item from the context by using the `removeContext(string $name)`
method.
