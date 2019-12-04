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
use Harleybalo\SocialBundle\Feeds\FeedsManager;
use Harleybalo\SocialBundle\Options\ProviderInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


class FeedsManagerTest extends KernelTestCase
{
    protected function setUp(): void
    {
        $container      = $this->getContainerMock();
        $this->manager  = new FeedsManager($container);
    }


    public function testNotFoundProvider(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->manager->request('not_found_provider');
    }


    /**
     * @return Mockery/MockInterface|ProviderInterface
     */
    protected function getContainerMock()
    {
        $mock = Mockery::mock(ContainerInterface::class);
        $mock->shouldIgnoreMissing();
        return $mock;
    }

    public function tearDown(): void
    {
        parent::tearDown();
        $this->manager = null;
        Mockery::close();
    }
}
