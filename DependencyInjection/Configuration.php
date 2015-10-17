<?php

namespace EdgarEz\CDNBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use eZ\Bundle\EzPublishCoreBundle\DependencyInjection\Configuration\SiteAccessAware\Configuration as SiteAccessConfiguration;


class Configuration extends SiteAccessConfiguration
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('edgar_ez_cdn');

        $systemNode = $this->generateScopeBaseNode($rootNode);
        $systemNode
            ->scalarNode('domain')->isRequired()->end()
            ->arrayNode('extensions')
                ->prototype('scalar')->end()
            ->end();

        return $treeBuilder;
    }
}
