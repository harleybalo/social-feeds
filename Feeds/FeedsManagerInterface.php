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

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * FeedsManagerInterface is the interface for Feed Request manager,
 * which process social api request
 *
 * @author  Harleybalo <adebalogoon@gmail.com>
 */
interface FeedsManagerInterface
{
    /**
     * Attempts to request social feeds object.
     *
     * @return array
     */
    public function request($providerKey);

    /**
     * Register providers
     *
     * @return array
     */
    public function registerProviders(ContainerInterface $container): void;
}
