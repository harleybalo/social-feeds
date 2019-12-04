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
 * Provider Interface
 *
 * @author  Harleybalo <adebalogoon@gmail.com>
 */
interface ProviderInterface
{
    /**
     * Returns Social options for $request.
     *
     * Any valid option will overwrite those of the previous ones.
     *
     *
     * @return array Social Bundle options
     */
    public function getOptions();
}
