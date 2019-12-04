<?php
/*
 * This file is part of the HarleybaloSocialBundle.
 *
 * (c) Harleybalo <adebalogoon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Harleybalo\SocialBundle\Options;


/**
 * SocialBundle Resolver
 * 
 * @author  Harleybalo <adebalogoon@gmail.com>
 */
class Resolver implements ResolverInterface
{
    /**
     * Configuration providers, indexed by numerical priority
     * 
     * @var ProviderInterface[][]
     */
    private $providers;

    /**
     * @param $providers ProviderInterface[]
     */
    public function __construct(array $providers = array())
    {
        $this->providers = $providers;
    }

    /**
     * Resolves the options based on {@see $providers} data
     *
     *
     * @return array Social options
     */
    public function getOptions($requestProvider = 'twitter')
    {
        $options = [];
        foreach ($this->providers as $provider) {
            $options[] = $provider->getOptions($requestProvider);
        }
        return $options;
    }
}
