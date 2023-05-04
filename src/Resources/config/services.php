<?php


namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Bytes\SymfonyBadge\Services\SymfonySupport;
use Bytes\SymfonyBadge\Services\Versions;

/**
 * @param ContainerConfigurator $container
 */
return static function (ContainerConfigurator $container) {

    $services = $container->services();

    $services->set('bytes_symfony_badge.symfony_support', SymfonySupport::class)
        ->args([
            service('bytes_symfony_badge.versions'),
        ])
        ->lazy()
        ->alias(SymfonySupport::class, 'bytes_symfony_badge.symfony_support')
        ->public();

    $services->set('bytes_symfony_badge.versions', Versions::class)
        ->args([
            service('http_client'),
            service('serializer'),
            ''
        ])
        ->lazy()
        ->alias(Versions::class, 'bytes_symfony_badge.versions')
        ->public();
};
