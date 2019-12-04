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
 * Configuration provider
 * 
 * @author  Harleybalo <adebalogoon@gmail.com>
 */
class ConfigProvider implements ProviderInterface
{
    protected $social;
    protected $defaults;

    /**
     * Config Provider constructor
     * 
     * @param array $config   Social Feed twitter|instagram
     * @param array $defaults Default options
     */
    public function __construct(array $config, array $defaults = array())
    {
        $this->defaults    = $defaults;
        $this->config      = $config;
    }

    /**
     * Get core options from yml
     * 
     * @param Request $request HTTPRequest
     * 
     * @return mixed
     */
    public function getOptions($requestProvider = 'twitter')
    {
        $defaults = $this->defaults;

        foreach ($this->defaults as $key => $default) {
            if (isset($this->config[$requestProvider])) {
                $defaults[$requestProvider] = array_merge($default, $this->config[$requestProvider]);
                continue;
            }
        }
        return $defaults;
    }
}
