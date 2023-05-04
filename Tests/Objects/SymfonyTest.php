<?php

namespace Bytes\SymfonyBadge\Tests\Objects;

use Bytes\SymfonyBadge\Objects\Symfony;
use Bytes\SymfonyBadge\Objects\SymfonyVersions;
use Bytes\SymfonyBadge\Tests\SymfonyTestTrait;
use Generator;
use PHPUnit\Framework\TestCase;


class SymfonyTest extends TestCase
{
    use SymfonyTestTrait;

    /**
     * @return Generator
     */
    public static function provideSimultaneousDotFourAndDotZero(): Generator
    {
        yield ['lts' => '6.0', 'result' => '5.4'];
        yield ['lts' => '6.2', 'result' => 'zzz'];
        yield ['lts' => '', 'result' => 'zzz'];
    }

    /**
     * @return void
     */
    public function testGetSetSecurityMaintainedVersions()
    {
        $symfony = new Symfony();
        self::assertEmpty($symfony->getSecurityMaintainedVersions());
        self::assertInstanceOf(Symfony::class, $symfony->setSecurityMaintainedVersions(['4.4']));
        $results = $symfony->getSecurityMaintainedVersions();
        self::assertCount(1, $results);
        $result = array_shift($results);
        self::assertEquals('4.4', $result);
    }

    /**
     * @return void
     */
    public function testNormalize()
    {
        $symfony = $this->getSymfony();
        $symfony->normalize();

        $normalized = $this->getSymfonyNormalized();
        self::assertEquals($normalized->getLatestStableVersion(), $symfony->getLatestStableVersion());
        self::assertEquals($normalized->getSupportedVersions(), $symfony->getSupportedVersions());
        self::assertEquals($normalized->getMaintainedVersions(), $symfony->getMaintainedVersions());
        self::assertEquals($normalized->getSecurityMaintainedVersions(), $symfony->getSecurityMaintainedVersions());
        self::assertEquals($normalized->getFlexSupportedVersions(), $symfony->getFlexSupportedVersions());
    }

    /**
     * @return void
     */
    public function testGetMaintainedVersionCount()
    {
        self::assertEquals(3, $this->getSymfony()->getMaintainedVersionCount());
    }

    /**
     * @return void
     */
    public function testGetSetSupportedVersions()
    {
        $symfony = new Symfony();
        self::assertEmpty($symfony->getSupportedVersions());
        self::assertInstanceOf(Symfony::class, $symfony->setSupportedVersions(['4.4']));
        $results = $symfony->getSupportedVersions();
        self::assertCount(1, $results);
        $result = array_shift($results);
        self::assertEquals('4.4', $result);
    }

    /**
     * @return void
     */
    public function testGetSupportedVersionsAsString()
    {
        self::assertEquals('5.4|6.2', $this->getSymfony()->getSupportedVersionsAsString());
    }

    /**
     * @dataProvider provideSimultaneousDotFourAndDotZero
     * @param string $lts
     * @param string $result
     * @return void
     */
    public function testGetSimultaneousDotFourAndDotZero($lts, $result)
    {
        $symfony = new Symfony();
        $symfony->setLatestStableVersion($lts);
        self::assertEquals($result, $symfony->getSimultaneousDotFourAndDotZero());
    }

    /**
     * @return void
     */
    public function testGetSetLatestStableVersion()
    {
        $symfony = new Symfony();
        self::assertNull($symfony->getLatestStableVersion());
        self::assertInstanceOf(Symfony::class, $symfony->setLatestStableVersion('6.2'));
        self::assertEquals('6.2', $symfony->getLatestStableVersion());
    }

    /**
     * @return void
     */
    public function testGetMaintainedVersionsAsString()
    {
        self::assertEquals('5.4|6.2|6.3', $this->getSymfony()->getMaintainedVersionsAsString());
    }

    /**
     * @return void
     */
    public function testGetSetSymfonyVersions()
    {
        $versions = $this->getSymfonyVersions();
        $symfony = new Symfony();
        self::assertEmpty($symfony->getSymfonyVersions());
        self::assertInstanceOf(Symfony::class, $symfony->setSymfonyVersions($versions));
        $result = $symfony->getSymfonyVersions();
        self::assertInstanceOf(SymfonyVersions::class, $result);
        self::assertEquals($versions, $result);
    }

    /**
     * @return void
     */
    public function testGetSetFlexSupportedVersions()
    {
        $symfony = new Symfony();
        self::assertEmpty($symfony->getFlexSupportedVersions());
        self::assertInstanceOf(Symfony::class, $symfony->setFlexSupportedVersions(['4.4']));
        $results = $symfony->getFlexSupportedVersions();
        self::assertCount(1, $results);
        $result = array_shift($results);
        self::assertEquals('4.4', $result);
    }

    /**
     * @return void
     */
    public function testGetSetMaintainedVersions()
    {
        $symfony = new Symfony();
        self::assertEmpty($symfony->getMaintainedVersions());
        self::assertInstanceOf(Symfony::class, $symfony->setMaintainedVersions(['4.4']));
        $results = $symfony->getMaintainedVersions();
        self::assertCount(1, $results);
        $result = array_shift($results);
        self::assertEquals('4.4', $result);
    }
}
