<?php
/*
 * This file is part of the HarleybaloSocialBundle.
 *
 * (c) Harleybalo <adebalogoon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Harleybalo\Tests\DependencyInjection;

use Fixtures\ProviderMock;
use Harleybalo\SocialBundle\DependencyInjection\Compiler\SocialConfigurationProviderPass;
use Harleybalo\SocialBundle\DependencyInjection\HarleybaloSocialExtension;
use Harleybalo\SocialBundle\Options\ConfigProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class SocialConfigurationProviderPassTest extends TestCase
{
    public function testCollectProviders(): void
    {
        $container = $this->getContainerBuilder();
        $container->compile();

        $arguments = $container->getDefinition('harleybalo_social.options_resolver')->getArguments();

        static::assertCount(4, $arguments[0] ?? []);
        static::assertSame(ConfigProvider::class, (string) $arguments[0][0]->getClass());
        static::assertSame('social.options_provider.test3', (string) $arguments[0][1]);
        static::assertSame('social.options_provider.test4', (string) $arguments[0][2]);
        static::assertSame('social.options_provider.test2', (string) $arguments[0][3]);
    }

    protected function getContainerBuilder(): ContainerBuilder
    {
        $extension = new HarleybaloSocialExtension();
        $container = new ContainerBuilder();
        $optionProviders = [
            'social.options_provider.test1' => (new Definition(ProviderMock::class))->setPublic(true),
            'social.options_provider.test2' => (new Definition(ProviderMock::class))->setPublic(true)->addTag('harleybalo_social.options_provider', ['priority' => 10]),
            'social.options_provider.test3' => (new Definition(ProviderMock::class))->setPublic(true)->addTag('harleybalo_social.options_provider', ['priority' => 5]),
            'social.options_provider.test4' => (new Definition(ProviderMock::class))->setPublic(true)->addTag('harleybalo_social.options_provider', ['priority' => 5]),
        ];
        $container->addDefinitions($optionProviders);
        $container->addCompilerPass(new SocialConfigurationProviderPass());
        $extension->load([], $container);
        $container->getDefinition('harleybalo_social.options_resolver')->setPublic(true);

        return $container;
    }
}
