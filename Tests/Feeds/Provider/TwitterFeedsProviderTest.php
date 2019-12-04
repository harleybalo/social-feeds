<?php
/*
 * This file is part of the HarleybaloSocialBundle.
 *
 * (c) Harleybalo <adebalogoon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Harleybalo\SocialBundle\Tests\Feeds;

use Mockery;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Harleybalo\SocialBundle\Feeds\Provider\TwitterFeedsProvider;


class TwitterFeedsProviderTest extends KernelTestCase
{
    protected function setUp(): void
    {
        $this->provider  = new TwitterFeedsProvider();
    }


    public function testNotFoundProvider(): void
    {
        $params = [
            'api_key'               => '1Rww1v7L924kFABWDeVrykTLk',
            'api_secret'            => 'aVJzFhNUmnxE20ggnPaz2MooZmRmEiikQMCsWJ2Js3dHGo5lRN',
            'api_url'               => 'https://api.twitter.com/1.1/search/tweets.json?q=from%3Atwitterdev&result_type=mixed',
            'access_token'          => '215362156-iKAL9STFMOJSfxTROfWlksPTRhAnDqhyZuSPu47y',
            'access_secret'         => '1g3Wt1dAlEhzwDBv54Wnlipc3U2oBBUVANuaV4ii1jjuw',
            'request_token_url'     => 'https://api.twitter.com/oauth/request_token',
            'access_token_url'      => 'https://api.twitter.com/oauth/access_token',
            'authorization_url'     => 'https://api.twitter.com/oauth/authorize',
            'version'               => '1.0.0',
            'provider_key'          => 'twitter',
        ];

        $result = $this->provider->request($params);
        self::assertIsArray(
            $result
        );
    }

    public function tearDown(): void
    {
        parent::tearDown();
        $this->manager = null;
        Mockery::close();
    }
}
