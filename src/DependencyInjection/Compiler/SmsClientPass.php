<?php

namespace App\DependencyInjection\Compiler;

use App\Sender\MessageSmsSender;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class SmsClientPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $definition = $container->findDefinition(MessageSmsSender::class);
        $taggedServices = $container->findTaggedServiceIds('sms_sender.client');

        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall('addClient', [new Reference($id)]);
        }
    }
}
