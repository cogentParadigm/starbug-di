<?php
namespace Starbug\DI\Handler;

use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;
use Starbug\DI\ConfigurationHandlerInterface;

class DefaultConfigurationHandler implements ConfigurationHandlerInterface {

  public function configure(ContainerBuilder $builder, array $options = []) {
    $config = include("etc/di.php");
    $config["base_directory"] = getcwd();
    $config["modules"] = $config["modules"] ?? [];
    $builder->addDefinitions($config);
    $this->addDefinitions($builder, $config["modules"]);
    return $config;
  }

  public function initialize(ContainerInterface $container) {
    if ($container->has("time_zone")) {
      date_default_timezone_set($container->get('time_zone'));
    }
    if ($container->has("error_handler")) {
      $container->get("error_handler")->register();
    }
  }

  protected function addDefinitions(ContainerBuilder $builder, array $modules, string $dir = "etc") {
    foreach ($modules as $module) {
      $path = $module["path"] ."/" . $dir ."/di.php";
      if (file_exists($path)) $builder->addDefinitions($path);
    }
  }
}
