<?php
/*
 * This file is part of the HarleybaloSocialBundle.
 *
 * (c) Harleybalo <adebalogoon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Harleybalo\SocialBundle\Feeds;

use Harleybalo\SocialBundle\Feeds\FeedsManagerInterface;
use Harleybalo\SocialBundle\Feeds\Provider\FeedsProviderInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


class FeedsManager implements FeedsManagerInterface
{
    private $providers = [];

    /**
     * @throws \InvalidArgumentException
     */
    public function __construct(ContainerInterface $container)
    {
        $this->registerProviders($container);
    }

    /**
     * For now the providers are registered
     * 
     * @return void
     */
    public function registerProviders(ContainerInterface $container): void
    {
        $providers = $container->getParameter('harleybalo_social');

        if (!empty($providers)) {
            $this->providers = $providers;
        }
    }

    /**
     * Make a request to the API 
     * 
     * @param $providerKey
     * 
     * {@inheritdoc}
     */
    public function request($providerKey)
    {
        $lastException  = null;
        foreach ($this->providers as $key => $provider) {
            if (empty($provider['provider'])) {
                $lastException = new \RuntimeException(sprintf('The provider with key "%s needs a valid provider class".', $key));
                continue;
            }
            $feedProvider = new $provider['provider'];
            if (!$feedProvider instanceof FeedsProviderInterface) {
                throw new \InvalidArgumentException(sprintf('Provider "%s" must implement the FeedsProviderInterface.', \get_class($provider)));
            }

            if (!$feedProvider->supports($providerKey)) {
                continue;
            }

            try {
                return $feedProvider->request($provider);
            } catch (\Exception $e) {
                $lastException = $e;
                break;
            }
        }

        if (null === $lastException) {
            $lastException = new \RuntimeException(sprintf('No Feeds Provider found for provider key of  "%s".', $providerKey));
        }

        throw $lastException;
    }
}
