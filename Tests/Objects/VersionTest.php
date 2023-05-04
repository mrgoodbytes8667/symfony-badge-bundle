<?php

namespace Bytes\SymfonyBadge\Tests\Objects;

use Bytes\SymfonyBadge\Objects\Version;
use PHPUnit\Framework\TestCase;

class VersionTest extends TestCase
{
    /**
     * @depends testMake
     * @param Version $version
     * @return void
     */
    public function testGetMajor(Version $version)
    {
        self::assertEquals(6, $version->getMajor());
    }

    /**
     * @depends testMake
     * @param Version $version
     * @return void
     */
    public function testGetMinor(Version $version)
    {
        self::assertEquals(2, $version->getMinor());
    }

    /**
     * @return Version
     */
    public function testMake()
    {
        $version = Version::make('6.2');
        self::assertInstanceOf(Version::class, $version);

        return $version;
    }
}
