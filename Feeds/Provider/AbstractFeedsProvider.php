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
 * AbstractFeedsProvider
 *
 * @author  Harleybalo <adebalogoon@gmail.com>
 */
abstract class AbstractFeedsProvider implements FeedsProviderInterface
{

    /**
     * Api Request
     * 
     * @param string $url
     * @param mixed $data
     * @param array $headers
     * @param string $method
     * 
     * @return array
     */
    public function apiRequest($url, $data = null, $headers = [], $method = 'GET'): array
    {
        $errorMsg = false;
        $ch = curl_init();
        if ($method === 'GET' && is_array($data)) {
            //$url .= '?' . http_build_query($data);
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        if (!empty($headers)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }

        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }


        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 400);

        $result = curl_exec($ch);

        if (curl_errno($ch)) {
            $errorMsg = curl_error($ch);
        }
        curl_close($ch);

        return [
            'response'  => $result,
            'error'     => $errorMsg,
        ];
    }


    /**
     * {@inheritdoc}
     */
    abstract public function getProviderParams(): array;

    /**
     * {@inheritdoc}
     */
    abstract public function getProviderKey(): string;

    /**
     * {@inheritdoc}
     */
    abstract public function supports($providerKey): bool;
}
