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
            ->setSymfonyVersions($this->getSymfonyVersions())
            ->setSecurityMaintainedVersions(['4.4'])
            ->setFlexSupportedVersions(['3.4', '4.0', '4.1', '4.2', '4.3', '4.4', '5.0', '5.1', '5.2', '5.3', '5.4', '6.0', '6.1', '6.2', '6.3']);
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
            ->setSymfonyVersions($this->getSymfonyVersions())
            ->setSecurityMaintainedVersions(['4.4.0.0'])
            ->setFlexSupportedVersions(['3.4.0.0', '4.0.0.0', '4.1.0.0', '4.2.0.0', '4.3.0.0', '4.4.0.0', '5.0.0.0', '5.1.0.0', '5.2.0.0', '5.3.0.0', '5.4.0.0', '6.0.0.0', '6.1.0.0', '6.2.0.0', '6.3.0.0']);
    }
}
