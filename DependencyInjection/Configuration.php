<?php declare(strict_types=1);

namespace Rd\AuthenticationBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 *
 * @author  Robert Durica <r.durica@gmail.com>
 * @package Rd\AuthenticationBundle\DependencyInjection
 */
class Configuration implements ConfigurationInterface
{

    /**
     * @inheritDoc
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('rd_authentication');

        $treeBuilder->getRootNode()
                    ->children()
                    ->scalarNode('homepage')
                    ->end()
                    ->scalarNode('background')
                    ->end()
                    ->arrayNode('email')
                    ->children()
                    ->scalarNode('from')
                    ->end()
                    ->end()
                    ->end();

        return $treeBuilder;
    }
}