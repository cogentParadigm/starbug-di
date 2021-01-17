<?php
use Starbug\DI\ContainerFactory;

include("vendor/autoload.php");

$container = ContainerFactory::withTestingHandler()
  ->create($args ?? []);
