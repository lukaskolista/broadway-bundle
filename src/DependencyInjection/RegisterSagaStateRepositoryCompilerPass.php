<?php

/*
 * This file is part of the broadway/broadway package.
 *
 * (c) Qandidate.com <opensource@qandidate.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Broadway\Bundle\BroadwayBundle\DependencyInjection;

use Broadway\EventStore\EventStore;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class RegisterSagaStateRepositoryCompilerPass extends CompilerPass
{
    public function process(ContainerBuilder $container)
    {
        $serviceParameter = 'broadway.saga.state.repository.service_id';
        if (! $container->hasParameter($serviceParameter)) {
            $container->setAlias(
                'broadway.saga.state.repository',
                'broadway.saga.state.in_memory_repository'
            );

            return;
        }

        $serviceId = $container->getParameter($serviceParameter);

        $this->assertDefinitionImplementsInterface($container, $serviceId, EventStore::class);

        $container->setAlias(
            'broadway.saga.state.repository',
            $serviceId
        );
    }
}
