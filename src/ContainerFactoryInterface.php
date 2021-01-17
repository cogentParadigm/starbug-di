<?php
namespace Starbug\DI;

interface ContainerFactoryInterface {

  /**
   * Add a handler.
   *
   * @param ConfigurationHandlerInterface $handler The handler.
   */
  public function addHandler(ConfigurationHandlerInterface $handler);

  /**
   * Create the container.
   *
   * @param array $definitions Container definitions.
   *   These defintions should override all others.
   */
  public function create(array $definitions = []);
}
