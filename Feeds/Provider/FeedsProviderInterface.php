<?php
/*
 * This file is part of the HarleybaloSocialBundle.
 *
 * (c) Harleybalo <adebalogoon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Harleybalo\SocialBundle\Feeds\Provider;

/**
 * FeedsProviderInterface is the interface for all request
 * providers.
 *
 * @author  Harleybalo <adebalogoon@gmail.com>
 */
interface FeedsProviderInterface
{
    /**
     * Api Request to Social platform.
     * 
     * @return array
     */
    public function apiRequest($url, $params = [], $header = [], $method = 'GET'): array;

    /**
     * Sets providers params
     * 
     * @return void
     */
    public function setProviderParams(array $providerParams);
}
