<?php

namespace AK\TwigExtensionsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('ak_twig_extensions');

        $rootNode
            ->children()
                ->arrayNode('parent_templates')->info('The names of the parent templates')
                    ->children()
                        ->scalarNode('main')
                            ->isRequired()
                            ->example('::layout.html.twig')
                        ->end()
                        ->scalarNode('ajax')
                            ->isRequired()
                            ->example('::ajax.html.twig')
                        ->end()
                    ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
