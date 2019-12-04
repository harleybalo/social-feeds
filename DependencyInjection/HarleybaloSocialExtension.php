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

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * @author Harleybalo <adebalogoon@gmail.com>
 */
class HarleybaloSocialExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration  = new Configuration();
        $config         = $this->processConfiguration($configuration, $configs);

        $default = array_merge(
            [
                'api_key'               => false,
                'api_secret'            => false,
                'api_url'               => 'https://api.twitter.com/labs/1/tweets',
                'request_token_url'     => 'https://api.twitter.com/oauth/request_token',
                'access_token_url'      => 'https://api.twitter.com/oauth/access_token',
                'authorization_url'     => 'https://api.twitter.com/oauth/authorize',
                'version'               => '1.0.1',
                'provider_key'          => 'twitter',
                'provider'              => 'Harleybalo\SocialBundle\Feeds\Provider\TwitterFeedsProvider',
            ],
            $config['twitter']
        );

        $container->setParameter('harleybalo_social', $config);
        $container->setParameter('harleybalo_social.twitter', $default);
        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');
    }
}
