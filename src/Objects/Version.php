<?php

namespace Bytes\SymfonyBadge\Objects;

use Symfony\Component\String\UnicodeString;
use function Symfony\Component\String\u;

class Version
{
    /**
     * @var UnicodeString
     */
    private UnicodeString $version;

    /**
     * @param string $version
     */
    public function __construct(string $version)
    {
        $this->version = u($version);
    }

    /**
     * @param string $version
     * @return static
     */
    public static function make(string $version): static
    {
        return new static($version);
    }

    /**
     * @return int
     */
    public function getMajor(): int
    {
        return (int)$this->version->beforeLast('.')->toString();
    }

    /**
     * @return int
     */
    public function getMinor(): int
    {
        return (int)$this->version->afterLast('.')->toString();
    }
}