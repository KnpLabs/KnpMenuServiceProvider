<?php

namespace Knp\Menu\Silex;

use Knp\Menu\Integration\Symfony\RoutingExtension;
use Knp\Menu\Matcher\Voter\RouteVoter;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Knp\Menu\Matcher\Matcher;
use Knp\Menu\MenuFactory;
use Knp\Menu\Renderer\ListRenderer;
use Knp\Menu\Renderer\TwigRenderer;
use Knp\Menu\Provider\ArrayAccessProvider as PimpleMenuProvider;
use Knp\Menu\Renderer\ArrayAccessProvider as PimpleRendererProvider;
use Knp\Menu\Twig\Helper;
use Knp\Menu\Twig\MenuExtension;
use Knp\Menu\Util\MenuManipulator;

class MenuServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['knp_menu.factory'] = function() use ($pimple) {
            $factory = new MenuFactory();

            if (isset($pimple['url_generator'])) {
                $factory->addExtension(new RoutingExtension($pimple['url_generator']));
            }

            return $factory;
        };

        $pimple['knp_menu.matcher'] = function() use ($pimple) {
            $matcher = new Matcher();

            if (isset($pimple['knp_menu.voter.router'])) {
                $matcher->addVoter($pimple['knp_menu.voter.router']);
            }

            if (isset($pimple['knp_menu.matcher.configure'])) {
                @trigger_error('Defining a "knp_menu.matcher.configure" to configure the matcher is deprecated since 1.1 and won\'t be supported in 2.0. Extend the "knp_menu.matcher" service instead.', E_USER_DEPRECATED);
                $pimple['knp_menu.matcher.configure']($matcher);
            }

            return $matcher;
        };

        $pimple['knp_menu.voter.router'] = function() use ($pimple) {
            return new RouteVoter($pimple['request_stack']);
        };

        $pimple['knp_menu.renderer.list'] = function() use ($pimple) {
            return new ListRenderer($pimple['knp_menu.matcher'], array(), $pimple['charset']);
        };

        $pimple['knp_menu.menu_provider'] = function() use ($pimple) {
            return new PimpleMenuProvider($pimple, $pimple['knp_menu.menus']);
        };

        if (!isset($pimple['knp_menu.menus'])) {
            $pimple['knp_menu.menus'] = array();
        }

        $pimple['knp_menu.renderer_provider'] = function() use ($pimple) {
            $pimple['knp_menu.renderers'] = array_merge(
                array('list' => 'knp_menu.renderer.list'),
                isset($pimple['knp_menu.renderer.twig']) ? array('twig' => 'knp_menu.renderer.twig') : array(),
                isset($pimple['knp_menu.renderers']) ? $pimple['knp_menu.renderers'] : array()
            );

            return new PimpleRendererProvider($pimple, $pimple['knp_menu.default_renderer'], $pimple['knp_menu.renderers']);
        };

        $pimple['knp_menu.menu_manipulator'] = function() use ($pimple) {
            return new MenuManipulator();
        };

        if (!isset($pimple['knp_menu.default_renderer'])) {
            $pimple['knp_menu.default_renderer'] = 'list';
        }

        $pimple['knp_menu.helper'] = function() use ($pimple) {
            return new Helper($pimple['knp_menu.renderer_provider'], $pimple['knp_menu.menu_provider'], $pimple['knp_menu.menu_manipulator'], $pimple['knp_menu.matcher']);
        };

        if (isset($pimple['twig'])) {
            $pimple['knp_menu.twig_extension'] = function() use ($pimple) {
                return new MenuExtension($pimple['knp_menu.helper'], $pimple['knp_menu.matcher'], $pimple['knp_menu.menu_manipulator']);
            };

            $pimple['knp_menu.renderer.twig'] = function() use ($pimple) {
                return new TwigRenderer($pimple['twig'], $pimple['knp_menu.template'], $pimple['knp_menu.matcher']);
            };

            if (!isset($pimple['knp_menu.template'])) {
                $pimple['knp_menu.template'] = 'knp_menu.html.twig';
            }

            $pimple['twig'] = $pimple->extend('twig', function(\Twig_Environment $twig) use ($pimple) {
                $twig->addExtension($pimple['knp_menu.twig_extension']);

                return $twig;
            });

            $pimple['twig.loader.filesystem'] = $pimple->extend('twig.loader.filesystem', function(\Twig_Loader_Filesystem $loader) {
                $ref = new \ReflectionClass('Knp\Menu\ItemInterface');

                $loader->addPath(dirname($ref->getFileName()).'/Resources/views');

                return $loader;
            });
        }
    }
}
