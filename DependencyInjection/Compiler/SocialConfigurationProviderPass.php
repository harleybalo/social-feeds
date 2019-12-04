<?php
/*
 * This file is part of the HarleybaloSocialBundle.
 *
 * (c) Harleybalo <adebalogoon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Harleybalo\SocialBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Compiler pass for the harleybalo_social.configuration.provider tag.
 * 
 * @author Harleybalo <adebalogoon@gmail.com>
 */
class SocialConfigurationProviderPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (!$container->hasDefinition('harleybalo_social.options_resolver')) {
            return;
        }

        $resolverDefinition         = $container->getDefinition('harleybalo_social.options_resolver');
        $optionsProvidersByPriority = [];

        foreach ($container->findTaggedServiceIds('harleybalo_social.options_provider') as $taggedServiceId => $tagAttributes) {
            foreach ($tagAttributes as $attribute) {
                $priority = isset($attribute['priority']) ? $attribute['priority'] : 0;
                $optionsProvidersByPriority[$priority][] = new Reference($taggedServiceId);
            }
        }

        if (count($optionsProvidersByPriority) > 0) {
            $resolverDefinition->setArguments(
                [$this->sortProviders($optionsProvidersByPriority)]
            );
        }
    }

    /**
     * Transforms a two-dimensions array of providers, indexed by priority, into a flat array of Reference objects
     * @param  array       $providersByPriority
     * @return Reference[]
     */
    protected function sortProviders(array $providersByPriority): array
    {
        ksort($providersByPriority);

        return call_user_func_array('array_merge', $providersByPriority);
    }
}
