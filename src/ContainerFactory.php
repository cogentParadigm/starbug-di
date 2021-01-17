<?php
namespace Starbug\DI;

use DI\ContainerBuilder;
use Starbug\DI\Handler\DefaultConfigurationHandler;
use Starbug\DI\Handler\TestingConfigurationHandler;

class ContainerFactory implements ContainerFactoryInterface {
  protected $handlers = [];
  public function addHandler(ConfigurationHandlerInterface $handler) {
    $this->handlers[] = $handler;
  }
  public function create(array $options = []) {
    $builder = new ContainerBuilder();
    foreach ($this->handlers as $handler) {
      $handler->configure($builder, $options);
    }
    $builder->addDefinitions($options);
    $container = $builder->build();
    $container->set('Psr\Container\ContainerInterface', $container);
    foreach ($this->handlers as $handler) {
      $handler->initialize($container);
    }
    return $container;
  }
  public static function withHandlers(...$handlers) {
    $factory = new static();
    foreach ($handlers as $handler) {
      $factory->addHandler($handler);
    }
    return $factory;
  }
  public static function withDefaultHandler() {
    return static::withHandlers(new DefaultConfigurationHandler());
  }
  public static function withTestingHandler() {
    return static::withHandlers(new TestingConfigurationHandler());
  }
}
