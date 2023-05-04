<?php

namespace Bytes\SymfonyBadge\Tests\Objects;

use Bytes\SymfonyBadge\Objects\SymfonyVersions;
use PHPUnit\Framework\TestCase;

class SymfonyVersionsTest extends TestCase
{
    /**
     * @return void
     */
    public function testGetSetNext()
    {
        $version = new SymfonyVersions();
        self::assertNull($version->getNext());
        self::assertInstanceOf(SymfonyVersions::class, $version->setNext('6.3.0-BETA1'));
        self::assertEquals('6.3.0-BETA1', $version->getNext());
        self::assertEquals('6.3.0.0-beta1', $version->getNextNormalized());
    }

    /**
     * @return void
     */
    public function testGetSetLts()
    {
        $version = new SymfonyVersions();
        self::assertNull($version->getLts());
        self::assertInstanceOf(SymfonyVersions::class, $version->setLts('6.3.0-BETA1'));
        self::assertEquals('6.3.0-BETA1', $version->getLts());
        self::assertEquals('6.3.0.0-beta1', $version->getLtsNormalized());
    }

    /**
     * @return void
     */
    public function testGetSetStable()
    {
        $version = new SymfonyVersions();
        self::assertNull($version->getStable());
        self::assertInstanceOf(SymfonyVersions::class, $version->setStable('6.3.0-BETA1'));
        self::assertEquals('6.3.0-BETA1', $version->getStable());
        self::assertEquals('6.3.0.0-beta1', $version->getStableNormalized());
    }
}
