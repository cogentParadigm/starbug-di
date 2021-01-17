<?php
namespace Starbug\DI\Handler;

use DI\ContainerBuilder;

class TestingConfigurationHandler extends DefaultConfigurationHandler {

  public function configure(ContainerBuilder $builder, array $options = []) {
    $config = parent::configure($builder, $options);
    if (file_exists("tests/etc/di.php")) {
      $config = include("tests/etc/di.php");
      $builder->addDefinitions($config);
    }
    $this->addDefinitions($builder, $config["modules"], "tests/etc");
    return $config;
  }
}
