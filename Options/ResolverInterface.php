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
 * ResolverInterface
 * 
 * @author  Harleybalo <adebalogoon@gmail.com>
 */
interface ResolverInterface
{
    /**
     * Returns options
     *
     * @internal param string $socials
     *
     * @return mixed
     */
    public function getOptions();
}
