<?php

namespace Bytes\SymfonyBadge\Tests;

use Bytes\SymfonyBadge\Objects\Symfony;
use Bytes\SymfonyBadge\Objects\SymfonyVersions;

trait SymfonyTestTrait
{
    /**
     * @return Symfony
     */
    public function getSymfony(): Symfony
    {
        $symfony = new Symfony();
        return $symfony->setLatestStableVersion('6.2')
            ->setSupportedVersions(['5.4', '6.2'])
            ->setMaintainedVersions(['5.4', '6.2', '6.3'])
            ->setSymfonyVersions($this->getSymfonyVersions());
    }

    /**
     * @return SymfonyVersions
     */
    public function getSymfonyVersions(): SymfonyVersions
    {
        return SymfonyVersions::create('5.4.22.0', '6.2.9.0', '6.3.0.0-dev');
    }

    /**
     * @return Symfony
     */
    public function getSymfonyNormalized(): Symfony
    {
        $normalizedSymfony = new Symfony();
        return $normalizedSymfony->setLatestStableVersion('6.2.0.0')
            ->setSupportedVersions(['5.4.0.0', '6.2.0.0'])
            ->setMaintainedVersions(['5.4.0.0', '6.2.0.0', '6.3.0.0'])
            ->setSymfonyVersions($this->getSymfonyVersions());
    }
}
