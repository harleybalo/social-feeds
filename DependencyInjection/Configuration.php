<?php
/*
 * This file is part of the HarleybaloSocialBundle.
 *
 * (c) Harleybalo <adebalogoon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Harleybalo\SocialBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ScalarNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Configuration  - Sets the default params
 * 
 * @author Harleybalo <adebalogoon@gmail.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('harleybalo_social');
        $rootNode    = $treeBuilder->getRootNode();

        $rootNode
            ->children()
            ->arrayNode('twitter')
            ->addDefaultsIfNotSet()
            ->append($this->getApiKey())
            ->append($this->getApiSecret())
            ->append($this->getApiUrl())
            ->append($this->getAccessKey())
            ->append($this->getAccessSecret())
            ->append($this->getApiTokenUrl())
            ->append($this->getVersion())
            ->append($this->getMaxLimit())
            ->append($this->getProviderKey())
            ->append($this->getProvider())
            ->end()
            ->end();


        return $treeBuilder;
    }


    private function getApiKey(): ScalarNodeDefinition
    {
        $node = new ScalarNodeDefinition('api_key');

        $node
            ->validate()
            ->ifTrue(function ($v) {
                return empty($v);
            })
            ->thenInvalid('api_key is required')
            ->end();

        return $node;
    }

    private function getApiTokenUrl(): ScalarNodeDefinition
    {
        $node = new ScalarNodeDefinition('api_token_url');
        $node
            ->validate()
            ->ifTrue(function ($v) {
                return empty($v);
            })
            ->thenInvalid('api_token_url is required')
            ->end();

        return $node;
    }

    private function getApiSecret(): ScalarNodeDefinition
    {
        $node = new ScalarNodeDefinition('api_secret');
        $node
            ->validate()
            ->ifTrue(function ($v) {
                return empty($v);
            })
            ->thenInvalid('api_secret is required')
            ->end();

        return $node;
    }

    private function getApiUrl(): ScalarNodeDefinition
    {
        $node = new ScalarNodeDefinition('api_url');

        $node
            ->validate()
            ->ifTrue(function ($v) {
                return empty($v);
            })
            ->thenInvalid('api_url is required')
            ->end();

        return $node;
    }

    private function getAccessKey(): ScalarNodeDefinition
    {
        $node = new ScalarNodeDefinition('access_key');
        $node
            ->validate()
            ->ifTrue(function ($v) {
                return empty($v);
            })
            ->thenInvalid('access_key is required')
            ->end();

        return $node;
    }

    private function getAccessSecret(): ScalarNodeDefinition
    {
        $node = new ScalarNodeDefinition('access_secret');

        $node
            ->validate()
            ->ifTrue(function ($v) {
                return empty($v);
            })
            ->thenInvalid('access_secret is required')
            ->end();

        return $node;
    }

    private function getVersion(): ScalarNodeDefinition
    {
        $node = new ScalarNodeDefinition('version');
        $node
            ->defaultValue('1.0')
            ->validate()
            ->ifTrue(function ($v) {
                return empty($v);
            })
            ->thenInvalid('version is required')
            ->end();

        return $node;
    }

    private function getProviderKey(): ScalarNodeDefinition
    {
        $node = new ScalarNodeDefinition('provider_key');
        $node
            ->defaultValue('twitter')
            ->validate()
            ->ifTrue(function ($v) {
                return empty($v);
            })
            ->thenInvalid('provider_key is required')
            ->end();

        return $node;
    }

    private function getProvider(): ScalarNodeDefinition
    {
        $node = new ScalarNodeDefinition('provider');
        $node
            ->validate()
            ->ifTrue(function ($v) {
                return empty($v);
            })
            ->thenInvalid('provider is required')
            ->end();

        return $node;
    }

    private function getMaxLimit(): ScalarNodeDefinition
    {
        $node = new ScalarNodeDefinition('max_limit');

        $node
            ->defaultValue(5)
            ->validate()
            ->ifTrue(function ($v) {
                return !is_numeric($v);
            })
            ->thenInvalid('max_limit must be an integer')
            ->end();

        return $node;
    }
}
