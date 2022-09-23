# DEPRECATED
Unfortunately we decided to not maintain this project anymore ([see why](https://knplabs.com/en/blog/news-for-our-foss-projects-maintenance)).
If you want to mark another package as a replacement for this one please send an email to [hello@knplabs.com](mailto:hello@knplabs.com).

# KnpMenuServiceProvider

Silex service provider for the KnpMenu library.

[![Build Status](https://travis-ci.org/KnpLabs/KnpMenuServiceProvider.svg)](http://travis-ci.org/KnpLabs/KnpMenuServiceProvider)
[![Latest Stable Version](https://poser.pugx.org/knplabs/knp-menu-silex/v/stable.svg)](https://packagist.org/packages/knplabs/knp-menu-silex)
[![Latest Unstable Version](https://poser.pugx.org/knplabs/knp-menu-silex/v/unstable.svg)](https://packagist.org/packages/knplabs/knp-menu-silex)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/KnpLabs/KnpMenuServiceProvider/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/KnpLabs/KnpMenuServiceProvider/?branch=master)

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
  UrlGeneratorServiceProvider is registered)
* **knp_menu.renderer.list**: The ListRenderer
* **knp_menu.renderer.twig**: The TwigRenderer (only when the Twig integration is available)
* **knp_menu.menu_manipulator**: The MenuManipulator
* **knp_menu.matcher**: The KnpMenu Matcher
* **knp_menu.voter.route**: The RouteVoter registered in the matcher. Unset it from the container to unregister it.

> **WARNING**
> The Twig integration is available only when the MenuServiceProvider is registered
> **after** the TwigServiceProvider in your application.
