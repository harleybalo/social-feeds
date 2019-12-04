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
 * TwitterFeedsProvider request feeds from Twitter API
 *
 * @author  Harleybalo <adebalogoon@gmail.com>
 */
class TwitterFeedsProvider extends AbstractFeedsProvider
{
    protected $providerKey = 'twitter';

    protected $providerParams = [];

    protected $bearerToken = null;

    protected $postParams = [];

    protected $getParams = [];


    /**
     * {@inheritdoc}
     */
    public function supports($providerKey): bool
    {
        return $providerKey === $this->getProviderKey();
    }

    /**
     * Request feeds
     * 
     * @param array $providerParams
     */
    public function request(array $providerParams)
    {
        $this->setProviderParams($providerParams);
        $requestMethod  = 'GET';
        $bearerToken    = $this->getBearerToken();
        $url            = $this->getProviderParam('api_url');
        $maxLimit       = $this->getProviderParam('max_limit');
        if (!empty($maxLimit)) {
            if (strpos($url, '?') !== false) {
                $url .= '&count=' . $maxLimit;
            } else {
                $url .= '?count=' . $maxLimit;
            }
        }
        $headers        = $this->generateOauthParams($url, $requestMethod);
        $headers[]      = 'Authorization: Bearer ' . $bearerToken;

        return $this->apiRequest($url, [], $headers, $requestMethod);
    }


    /**
     * Get postfields array (simple getter)
     *
     * @return array $this->postfields
     */
    public function getPostfields()
    {
        return $this->postfields;
    }


    /**
     * Since the OAuth data is passed in a url, special characters need to be encoded
     */
    private function getBearerToken()
    {
        if ($this->bearerToken !== null) {
            return $this->bearerToken;
        }

        $headers = [
            'Authorization: Basic ' . $this->encodeAppAuthorization(),
        ];

        $result  = $this->apiRequest(
            $this->getProviderParam('api_token_url'),
            "grant_type=client_credentials",
            $headers,
            'POST'
        );

        $errorMessage   = 'Request could not be completed';

        if (!empty($result['response']) && empty($result['error'])) {
            $response = json_decode($result['response'], true);
            if (!empty($response['access_token'])) {
                return $this->bearerToken = $response['access_token'];
            }
        }

        throw new \Exception($result['error'] ?? $errorMessage);
    }

    /**
     * Encode application authorization header with base64.
     *
     * @param Consumer $consumer
     *
     * @return string
     */
    private function encodeAppAuthorization()
    {
        $key    = rawurlencode($this->getProviderParam('api_key'));
        $secret = rawurlencode($this->getProviderParam('api_secret'));
        return base64_encode($key . ':' . $secret);
    }


    /**
     * Set post params string
     *
     * @param array $array Get key and value pairs
     *
     * @return void 
     * @throws \Exception
     */
    public function setPostfields(array $params, $url = null)
    {
        if (!is_null($this->getGetfield())) {
            throw new \Exception('Only one request type is allowed');
        }

        if (!empty($params['status']) && substr($params['status'], 0, 1) === '@') {
            $params['status'] = sprintf("\0%s", $params['status']);
        }
        foreach ($params as  &$value) {
            if (is_bool($value)) {
                $value = ($value === true) ? 'true' : 'false';
            }
        }

        $this->postParams = $params;
    }

    /**
     * Build the Oauth object using params set in construct and additionals
     *
     * @param string $url          
     *
     * @throws \Exception
     */
    public function generateOauthParams($url, $requestMethod)
    {
        $accessSecret   = $this->getProviderParam('api_secret');
        $tokenSecret    = $this->getProviderParam('access_secret');

        $oauth = array(
            'oauth_consumer_key'    => $this->getProviderParam('api_key'),
            'oauth_nonce'           => md5(microtime() . mt_rand()),
            'oauth_signature_method' => 'HMAC-SHA1',
            'oauth_token'           => $this->getProviderParam('access_token'),
            'oauth_timestamp'       => time(),
            'oauth_version'         => '1.1'
        );

        $baseInfo       = $this->generateURIString($url, $requestMethod, $oauth);
        $compositeKey   = rawurlencode($accessSecret) . '&' . rawurlencode($tokenSecret);
        $oauthSignature = base64_encode(hash_hmac('sha1', $baseInfo, $compositeKey, true));

        $oauth['oauth_signature'] = $oauthSignature;
        return $oauth;
    }




    /**
     * Set get params string
     *
     * @param string $str Get key and value pairs
     *    
     * @return void 
     * @throws \Exception
     */
    public function setGetParams($str)
    {
        if (!empty($this->getPostParams())) {
            throw new \Exception('Only one request type is allowed');
        }

        $getParams  = preg_replace('/^\?/', '', explode('&', $str));
        $params     = [];

        foreach ($getParams as $field) {
            if ($field !== '') {
                list($key, $value) = explode('=', $field);
                $params[$key] = $value;
            }
        }

        $this->getParams = '?' . http_build_query($params, '', '&');
    }

    /**
     * Returns get parameters array 
     *
     * @return array $this->getParams
     */
    public function getGetParams(): array
    {
        return $this->getParams;
    }

    /**
     * Returns post parameters array 
     *
     * @return array $this->postParams
     */
    public function getPostParams(): array
    {
        return $this->postParams;
    }

    /**
     * Set providers params
     * 
     * @param array
     * 
     * @return void
     * @throws \InvalidArgumentException
     */
    public function setProviderParams(array $providerParams): void
    {
        if (
            empty($providerParams['access_key'])
            || empty($providerParams['access_secret'])
            || empty($providerParams['api_key'])
            || empty($providerParams['api_secret'])
        ) {
            throw new \InvalidArgumentException('Incomplete configuration params passed');
        }

        $this->providerParams = $providerParams;
    }

    /**
     * Generate URL string for Curl request
     *
     * @param string $uri
     * @param string $method
     * @param array  $params
     *
     * @return string
     */
    private function generateURIString($uri, $method, $params)
    {
        ksort($params);
        $return = [];
        foreach ($params as $key => $value) {
            $return[] = rawurlencode($key) . '=' . rawurlencode($value);
        }

        return $method . "&" . rawurlencode($uri) . '&' . rawurlencode(implode('&', $return));
    }


    /**
     * Generate authorization header for CURL Request
     *
     * @param array $oauth
     *
     * @return string $return Header used by cURL for request
     */
    private function generateAuthHeader(array $oauth)
    {
        $return = 'Authorization: OAuth ';
        $values = [];
        $allowedKeys = [
            'oauth_consumer_key',
            'oauth_nonce',
            'oauth_signature',
            'oauth_signature_method',
            'oauth_timestamp',
            'oauth_token',
            'oauth_version',
        ];

        foreach ($oauth as $key => $value) {
            if (in_array($key, $allowedKeys)) {
                $values[] = "$key=\"" . rawurlencode($value) . "\"";
            }
        }
        $return .= implode(', ', $values);

        return $return;
    }


    protected function getProviderParam($key)
    {
        return $this->providerParams[$key] ?? null;
    }

    public function getProviderParams(): array
    {
        return $this->providerParams;
    }

    public function getProviderKey(): string
    {
        return $this->providerKey;
    }
}
