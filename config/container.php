<?php
/**
 * Initialize a dependency injection container that implemented PSR-11 and return the container.
 */

declare(strict_types=1);

use Hyperf\Context\ApplicationContext;
use Hyperf\Di\Container;
use Hyperf\Di\Definition\DefinitionSourceFactory;
use Easy\Annotation\DependProxyCollector;
use Psr\Container\ContainerInterface;

$container = new Container((new DefinitionSourceFactory())());
DependProxyCollector::walk([$container, 'define']);

if (! $container instanceof ContainerInterface) {
    throw new RuntimeException('The dependency injection container is invalid.');
}
return ApplicationContext::setContainer($container);
