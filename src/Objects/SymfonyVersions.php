<?php

namespace Bytes\SymfonyBadge\Objects;

use Composer\Semver\VersionParser;

class SymfonyVersions
{
    /**
     * @var string|null
     */
    private $lts;

    /**
     * @var string|null
     */
    private $stable;

    /**
     * @var string|null
     */
    private $next;

    /**
     * @return string|null
     */
    public function getLts(): ?string
    {
        return $this->lts;
    }

    /**
     * @param string|null $lts
     * @return $this
     */
    public function setLts(?string $lts): self
    {
        $this->lts = $lts;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLtsNormalized(): ?string
    {
        return static::normalizeVersion($this->getLts());
    }

    /**
     * @param string|null $version
     * @return string|null
     */
    private static function normalizeVersion(?string $version): ?string
    {
        return empty($version) ? $version : (new VersionParser())->normalize($version);
    }

    /**
     * @return string|null
     */
    public function getStable(): ?string
    {
        return $this->stable;
    }

    /**
     * @param string|null $stable
     * @return $this
     */
    public function setStable(?string $stable): self
    {
        $this->stable = $stable;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getStableNormalized(): ?string
    {
        return static::normalizeVersion($this->getStable());
    }

    /**
     * @return string|null
     */
    public function getNext(): ?string
    {
        return $this->next;
    }

    /**
     * @param string|null $next
     * @return $this
     */
    public function setNext(?string $next): self
    {
        $this->next = $next;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getNextNormalized(): ?string
    {
        return static::normalizeVersion($this->getNext());
    }

    /**
     * @return int
     */
    public function countAll(): int
    {
        return count($this->getAll());
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        return array_values(array_unique([
            $this->lts,
            $this->stable,
            $this->next
        ]));
    }

    /**
     * @param string|null $lts
     * @param string|null $stable
     * @param string|null $next
     * @return static
     */
    public static function create(?string $lts, ?string $stable, ?string $next): static {
        return (new static())
            ->setLts($lts)
            ->setStable($stable)
            ->setNext($next);
    }
}
