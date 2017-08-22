# KnpMenuServiceProvider

Silex service provider for the KnpMenu library.

## Installation

Installation is done using Composer:

```bash
$ composer require knplabs/knp-menu-silex
```

## Usage

Register the MenuServiceProvider in your application:

```php
use Knp\Menu\Silex\MenuServiceProvider;

$app->register(new MenuServiceProvider());
```


#### Parameters

* **knp_menu.menus** (optional): an array of ``alias => id`` pair for the
  [menu provider](02-Twig-Integration.markdown#menu-provider).
* **knp_menu.renderers** (optional): an array of ``alias => id`` pair for
  the [renderer provider](02-Twig-Integration.markdown#renderer-provider).
* **knp_menu.default_renderer** (optional): the alias of the default renderer (default to `'list'`)
* **knp_menu.template** (optional): The template used by default by the TwigRenderer.

#### Services

* **knp_menu.factory**: The menu factory (it is a router-aware one if the
  UrlGeneratorExtension is registered)
* **knp_menu.renderer.list**: The ListRenderer
* **knp_menu.renderer.twig**: The TwigRenderer (only when the Twig integration is available)
* **knp_menu.menu_manipulator**: The MenuManipulator

> **WARNING**
> The Twig integration is available only when the MenuServiceProvider is registered
> **after** the TwigServiceProvider in your application.
