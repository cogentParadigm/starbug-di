# Starbug Dependency Injection

A dependecy injection meta package and container initialization library for [PHP-DI](https://github.com/PHP-DI/PHP-DI).

# What's included

- [PHP-DI/PHP-DI](https://github.com/PHP-DI/PHP-DI) The actual dependency injection library.
- ContainerFactory - A configurable factory for initializing containers and running post initialization steps.
- DefaultConfigurationHandler - A default handler for the factory that loads container definitions from `etc/di.php` in the root package and overrides from `etc/di.php` in modules that provide it. It can also set the default timezone and register an error handler after the container is initialized.

# Usage

## Application bootstrapping

The simplest way to use this library is to bootstrap your application with it and let it use the default configuration handler.

```php
include("vendor/starbug/di/bootstrap/init.php");

// You now have a Psr\Container\ContainerInterface instance
$application = $container->make("MyApp");
```

## Direct initialization

To do the same thing directly.

```php
use Starbug\DI\ContainerFactory;

include("vendor/autoload.php");

$container = ContainerFactory::withDefaultHandler()
  ->create();

// You now have a Psr\Container\ContainerInterface instance
$application = $container->make("MyApp");
```

## Definitions

The default handler will look for a file at `etc/di.php` to load definitions from. To customize `MyApp` our file might look like this.

```
return [
  "MyApp" => function () {
    $app = new MyApp();
    $app->addMiddleware(new MyMiddleware());
    return $app;
  }
];
```

See the [PHP-DI documentation on PHP definitions](https://php-di.org/doc/php-definitions.html).

## Modules

If you are using [starbug/composer-modules-plugin](https://github.com/cogentParadigm/composer-modules-plugin), the default handler will also check each module for an `etc/di.php` file to load additional definitions from.

## Custom Handlers

To use custom handlers, call `withHandlers` instead of `withDefaultHandler` and pass your handlers.

```php
use Starbug\DI\ContainerFactory;

$container = ContainerFactory::withHandlers(
  new MyHandler(),
  new SecondHandler()
)->create();
```

Alternatively, if you don't want to use the static helper method you can easily do it manually.

```php
use Starbug\DI\ContainerFactory;

$factory = new ContainerFactory();
$factory->addHandler(new MyHandler());
$container = $factory->create();
```




