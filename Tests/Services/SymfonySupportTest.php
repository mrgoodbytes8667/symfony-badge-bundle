<?php

namespace Bytes\SymfonyBadge\Tests\Services;

use Bytes\SymfonyBadge\Enums\Color;
use Bytes\SymfonyBadge\Enums\Condition;
use Bytes\SymfonyBadge\Objects\Symfony;
use Bytes\SymfonyBadge\Services\SymfonySupport;
use Bytes\SymfonyBadge\Services\Versions;
use Bytes\SymfonyBadge\Tests\SymfonyTestTrait;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;


class SymfonySupportTest extends TestCase
{
    use SymfonyTestTrait;

    private ?SymfonySupport $support = null;

    public static function provideConditions()
    {
        yield '^5.2 symfony' => ['condition' => Condition::SYMFONY, 'version' => '^5.2', 'all' => false, 'lts' => true, 'stable' => false, 'dev' => false, 'supports' => true, 'color' => Color::YELLOW];
        yield '^5.2 symfony test' => ['condition' => Condition::SYMFONY_TEST, 'version' => '^5.2', 'all' => false, 'lts' => true, 'stable' => false, 'dev' => false, 'supports' => true, 'color' => Color::YELLOW];
        yield '^5.2 lts' => ['condition' => Condition::LTS, 'version' => '^5.2', 'all' => false, 'lts' => true, 'stable' => false, 'dev' => false, 'supports' => true, 'color' => Color::GREEN];
        yield '^5.2 stable' => ['condition' => Condition::STABLE, 'version' => '^5.2', 'all' => false, 'lts' => true, 'stable' => false, 'dev' => false, 'supports' => false, 'color' => Color::RED];
        yield '^5.2 dev' => ['condition' => Condition::DEV, 'version' => '^5.2', 'all' => false, 'lts' => true, 'stable' => false, 'dev' => false, 'supports' => false, 'color' => Color::RED];
        yield '^6.2 symfony' => ['condition' => Condition::SYMFONY, 'version' => '^6.2', 'all' => false, 'lts' => false, 'stable' => true, 'dev' => true, 'supports' => true, 'color' => Color::GREEN];
        yield '^6.2 symfony test' => ['condition' => Condition::SYMFONY_TEST, 'version' => '^6.2', 'all' => false, 'lts' => false, 'stable' => true, 'dev' => true, 'supports' => true, 'color' => Color::GREEN];
        yield '^6.2 lts' => ['condition' => Condition::LTS, 'version' => '^6.2', 'all' => false, 'lts' => false, 'stable' => true, 'dev' => true, 'supports' => false, 'color' => Color::RED];
        yield '^6.2 stable' => ['condition' => Condition::STABLE, 'version' => '^6.2', 'all' => false, 'lts' => false, 'stable' => true, 'dev' => true, 'supports' => true, 'color' => Color::GREEN];
        yield '^6.2 dev' => ['condition' => Condition::DEV, 'version' => '^6.2', 'all' => false, 'lts' => false, 'stable' => true, 'dev' => true, 'supports' => true, 'color' => Color::GREEN];
        yield '^5.4 | ^6.0 symfony' => ['condition' => Condition::SYMFONY, 'version' => '^5.4 | ^6.0', 'all' => true, 'lts' => true, 'stable' => true, 'dev' => true, 'supports' => true, 'color' => Color::BRIGHTGREEN];
        yield '^5.4 | ^6.0 symfony test' => ['condition' => Condition::SYMFONY_TEST, 'version' => '^5.4 | ^6.0', 'all' => true, 'lts' => true, 'stable' => true, 'dev' => true, 'supports' => true, 'color' => Color::BRIGHTGREEN];
        yield '^5.4 | ^6.0 lts' => ['condition' => Condition::LTS, 'version' => '^5.4 | ^6.0', 'all' => true, 'lts' => true, 'stable' => true, 'dev' => true, 'supports' => true, 'color' => Color::GREEN];
        yield '^5.4 | ^6.0 stable' => ['condition' => Condition::STABLE, 'version' => '^5.4 | ^6.0', 'all' => true, 'lts' => true, 'stable' => true, 'dev' => true, 'supports' => true, 'color' => Color::GREEN];
        yield '^5.4 | ^6.0 dev' => ['condition' => Condition::DEV, 'version' => '^5.4 | ^6.0', 'all' => true, 'lts' => true, 'stable' => true, 'dev' => true, 'supports' => true, 'color' => Color::GREEN];

        yield '>=6.2 <6.3 symfony' => ['condition' => Condition::SYMFONY, 'version' => '>=6.2 <6.3', 'all' => false, 'lts' => false, 'stable' => true, 'dev' => false, 'supports' => true, 'color' => Color::YELLOWGREEN];
        yield '>=5.4 <6.2 symfony' => ['condition' => Condition::SYMFONY, 'version' => '>=5.4 <6.2', 'all' => false, 'lts' => true, 'stable' => false, 'dev' => false, 'supports' => true, 'color' => Color::YELLOW];
        yield '^6.3 symfony' => ['condition' => Condition::SYMFONY, 'version' => '^6.3', 'all' => false, 'lts' => false, 'stable' => false, 'dev' => true, 'supports' => true, 'color' => Color::ORANGE];
        yield '<5.0 symfony' => ['condition' => Condition::SYMFONY, 'version' => '<5.0', 'all' => false, 'lts' => false, 'stable' => false, 'dev' => false, 'supports' => false, 'color' => Color::RED];
    }

    /**
     * @return void
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function testGetSupports()
    {
        list('all' => $supportsAll, 'lts' => $supportsLts, 'stable' => $supportsStable, 'dev' => $supportsDev) = $this->support->getSupports('^6.2');

        self::assertFalse($supportsAll);
        self::assertFalse($supportsLts);
        self::assertTrue($supportsStable);
        self::assertTrue($supportsDev);

        list('all' => $supportsAll, 'lts' => $supportsLts, 'stable' => $supportsStable, 'dev' => $supportsDev) = $this->support->getSupports('^5.4 | ^6.0');

        self::assertTrue($supportsAll);
        self::assertTrue($supportsLts);
        self::assertTrue($supportsStable);
        self::assertTrue($supportsDev);

        list('all' => $supportsAll, 'lts' => $supportsLts, 'stable' => $supportsStable, 'dev' => $supportsDev) = $this->support->getSupports('^4.4');

        self::assertFalse($supportsAll);
        self::assertFalse($supportsLts);
        self::assertFalse($supportsStable);
        self::assertFalse($supportsDev);
    }

    /**
     * @dataProvider provideConditions
     * @param $condition
     * @param $version
     * @param $all
     * @param $lts
     * @param $stable
     * @param $dev
     * @param $supports
     * @param $color
     * @return void
     */
    public function testGetForCondition($condition, $version, $all, $lts, $stable, $dev, $supports, $color)
    {
        $output = $this->support->getForCondition($version, $condition);
        self::assertIsArray($output);
        self::assertEquals($all, $output['all']);
        self::assertEquals($lts, $output['lts']);
        self::assertEquals($stable, $output['stable']);
        self::assertEquals($dev, $output['dev']);
        self::assertEquals($supports, $output['supports']);
        self::assertEquals($color, $output['color']);
    }

    public function testGetReleases() {
        $releases = $this->support->getReleases();
        self::assertInstanceOf(Symfony::class, $releases);
        self::assertEquals('6.2', $releases->getLatestStableVersion());
    }

    public function testGetNormalizedReleases() {
        $releases = $this->support->getNormalizedReleases();
        self::assertInstanceOf(Symfony::class, $releases);
        self::assertEquals('6.2.0.0', $releases->getLatestStableVersion());
    }

    public function testGetVersions() {
        $versions = $this->support->getVersions();
        self::assertInstanceOf(Versions::class, $versions);
        $releases = $versions->getReleases();
        self::assertInstanceOf(Symfony::class, $releases);
        self::assertEquals('6.2', $releases->getLatestStableVersion());

        $releases = $versions->getNormalizedReleases();
        self::assertInstanceOf(Symfony::class, $releases);
        self::assertEquals('6.2.0.0', $releases->getLatestStableVersion());
    }

    public function setUp(): void
    {
        $symfony = $this->getSymfony();
        $normalizedSymfony = $this->getSymfonyNormalized();

        $stub = $this->createStub(Versions::class);
        $stub->method('getReleases')
            ->willReturn($symfony);
        $stub->method('getNormalizedReleases')
            ->willReturn($normalizedSymfony);

        $this->support = new SymfonySupport($stub);
    }

    public function tearDown(): void
    {
        $this->support = null;
    }
}
