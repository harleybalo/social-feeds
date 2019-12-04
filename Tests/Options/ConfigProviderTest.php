<?php
/*
 * This file is part of the HarleybaloSocialBundle.
 *
 * (c) Harleybalo <adebalogoon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Harleybalo\SocialBundle\Tests\Options;

use Harleybalo\SocialBundle\Options\ConfigProvider;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ConfigProviderTest extends KernelTestCase
{

    protected function setUp(): void
    { }

    protected $defaultOptions = [
        'twitter' => [
            'api_key'               => 'ddddd',
            'api_secret'            => 'aaaa',
            'api_url'               => 'https://api.twitter.com/labs/1/tweets',
            'access_key'            => 'xxxxxx',
            'access_secret'         => 'xxxxxxsdsdsd',
            'max_limit'             => 2,
            'version'               => '1.0.1',
            'provider_key'          => 'twitter',
            'provider'              => 'Harlebalo/SocialBundle/Feeds/Provider/TwitterFeedProvider',
        ],
    ];

    public function testGetConfigConfig(): void
    {
        $params = [
            'twitter' => [
                'api_key'               => 'ddddd',
                'api_secret'            => 'aaaa',
                'api_url'               => 'https://api.twitter.com/labs/1/tweets',
                'access_key'            => 'xxxxxx',
                'access_secret'         => 'xxxxxxsdsdsd',
                'max_limit'             => 2,
                'version'               => '1.0.0',
                'provider_key'          => 'twitter',
                'provider'              => 'Harlebalo/SocialBundle/Feeds/Provider/TwitterFeedProvider',
            ],
        ];

        $provider = $this->getProvider($params);
        self::assertEquals(
            $params,
            $provider->getOptions()
        );
    }

    public function testGetDefaultConfig(): void
    {
        $params     = [];
        $provider   = $this->getProvider($params);

        self::assertEquals(
            $this->defaultOptions,
            $provider->getOptions()
        );
    }

    protected function getProvider(array $params): ConfigProvider
    {
        $options = $this->defaultOptions;
        return new ConfigProvider(
            $params,
            $options
        );
    }
}
