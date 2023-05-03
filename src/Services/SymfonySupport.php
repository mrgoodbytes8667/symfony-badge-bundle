<?php

namespace Bytes\SymfonyBadge\Services;

use Bytes\SymfonyBadge\Enums\Color;
use Bytes\SymfonyBadge\Enums\Condition;
use Bytes\SymfonyBadge\Objects\Symfony;
use Composer\Semver\Semver;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class SymfonySupport
{
    private ?Symfony $releases = null;

    /**
     * @param Versions $versions
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function __construct(Versions $versions)
    {
        $this->releases = $versions->getNormalizedReleases();
    }

    #[ArrayShape(['all' => "bool", 'lts' => "bool", 'stable' => "bool", 'dev' => "bool", 'supports' => "bool", 'color' => Color::class])]
    public function getForCondition(string $ver, Condition $label = Condition::SYMFONY)
    {
        $return = $this->getSupports($ver);
        list('all' => $supportsAll, 'lts' => $supportsLts, 'stable' => $supportsStable, 'dev' => $supportsDev) = $return;

        switch ($label) {
            case Condition::SYMFONY:
            case Condition::SYMFONY_TEST:

                $return['supports'] = true;

                if ($supportsAll) {
                    $return['color'] = Color::BRIGHTGREEN;
                    return $return;
                }

                if ($supportsStable) {
                    if ($supportsDev) {
                        $return['color'] = Color::GREEN;
                        return $return;
                    } else {
                        $return['color'] = Color::YELLOWGREEN;
                        return $return;
                    }
                } else {
                    if ($supportsLts) {
                        $return['color'] = Color::YELLOW;
                        return $return;
                    } elseif ($supportsDev) {
                        $return['color'] = Color::ORANGE;
                        return $return;
                    } else {
                        $return['supports'] = false;
                        $return['color'] = Color::RED;

                        return $return;
                    }
                }

                break;
            case Condition::LTS:
            case Condition::STABLE:
            case Condition::DEV:
                $supports = false;
                switch ($label) {
                    case Condition::LTS:
                        $supports = $supportsAll || $supportsLts;
                        break;
                    case Condition::STABLE:
                        $supports = $supportsAll || $supportsStable;
                        break;
                    case Condition::DEV:
                        $supports = $supportsAll || $supportsDev;
                        break;
                }

                $return['supports'] = $supports;
                $return['color'] = $supports ? Color::GREEN : Color::RED;
                return $return;
                break;
        }
    }

    /**
     * @param string $ver
     * @return false[]|true[]
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    #[ArrayShape(['all' => "bool", 'lts' => "bool", 'stable' => "bool", 'dev' => "bool"])]
    public function getSupports(string $ver): array
    {
        $return = [
            'all' => false,
            'lts' => false,
            'stable' => false,
            'dev' => false,
        ];

        // All -> brightgreen
        // Stable + Dev -> green
        // Stable + LTS -> yellowgreen
        // LTS -> yellow
        // None, -> red

        $supportsAll = $this->releases->getSymfonyVersions()->countAll() === count(Semver::satisfiedBy($this->releases->getSymfonyVersions()->getAll(), $ver));
        if ($supportsAll) {
            return [
                'all' => true,
                'lts' => true,
                'stable' => true,
                'dev' => true,
            ];
        }

        $return['stable'] = Semver::satisfies($this->releases->getSymfonyVersions()->getStable(), $ver);
        $return['lts'] = Semver::satisfies($this->releases->getSymfonyVersions()->getLts(), $ver);
        $return['dev'] = Semver::satisfies($this->releases->getSymfonyVersions()->getNext(), $ver);

        return $return;
    }
}
