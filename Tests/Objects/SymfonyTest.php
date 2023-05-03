<?php

namespace Bytes\SymfonyBadge\Tests\Objects;

use Bytes\SymfonyBadge\Enums\Color;
use Bytes\SymfonyBadge\Enums\Condition;
use Bytes\SymfonyBadge\Objects\Symfony;
use Bytes\SymfonyBadge\Objects\SymfonyVersions;
use Bytes\SymfonyBadge\Services\SymfonySupport;
use Bytes\SymfonyBadge\Services\Versions;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;


class SymfonyTest extends TestCase
{
    /**
     * @return void
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function testGetSupports()
    {
        $symfonyVersions = SymfonyVersions::create('5.4.22.0', '6.2.9.0', '6.3.0.0-dev');

        $symfony = new Symfony();
        $symfony->setLatestStableVersion('6.2')
            ->setSupportedVersions(['5.4', '6.2'])
            ->setMaintainedVersions(['5.4', '6.2', '6.3'])
            ->setSymfonyVersions($symfonyVersions);
        $normalizedSymfony = new Symfony();
        $normalizedSymfony->setLatestStableVersion('6.2.0.0')
            ->setSupportedVersions(['5.4.0.0', '6.2.0.0'])
            ->setMaintainedVersions(['5.4.0.0', '6.2.0.0', '6.3.0.0'])
            ->setSymfonyVersions($symfonyVersions);

        self::assertNotNull($symfonyVersions);
    }
}
