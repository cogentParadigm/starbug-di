<?php
namespace Starbug\DI;

use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;

interface ConfigurationHandlerInterface {

  /**
   * Add definitions to the container builder.
   *
   * @param ContainerBuilder $builder The builder.
   */
  public function configure(ContainerBuilder $builder, array $options = []);

  /**
   * Add initialization steps once the container has been built.
   * You can also use this to do environment configuration such
   * as setting the default timezone or registering an error handler,
   * which you might want to do *sooner* than your http middleware
   * and/or across SAPIs.
   *
   * @param ContainerInterface $container The container.
   */
  public function initialize(ContainerInterface $container);
}
