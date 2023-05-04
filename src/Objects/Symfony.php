<?php


namespace Bytes\SymfonyBadge\Objects;


use Composer\Semver\VersionParser;
use function Symfony\Component\String\u;

/**
 * Class Symfony
 * @package App\Objects
 */
class Symfony
{
    /**
     * @var string|null
     */
    private ?string $latest_stable_version = null;

    /**
     * @var string[]|null
     */
    private ?array $supported_versions = [];

    /**
     * @var string[]|null
     */
    private ?array $maintained_versions = [];

    /**
     * @var SymfonyVersions|null
     */
    private ?SymfonyVersions $symfony_versions = null;

    /**
     * @var string[]|null
     */
    private ?array $security_maintained_versions = [];

    /**
     * @var string[]|null
     */
    private ?array $flex_supported_versions = [];

    /**
     * @return string
     */
    public function getSimultaneousDotFourAndDotZero(): string
    {
        if (empty($this->latest_stable_version)) {
            return 'zzz';
        }

        $version = u($this->latest_stable_version);
        if (!$version->afterLast('.')->equalsTo('0')) {
            return 'zzz';
        }

        $major = Version::make($this->latest_stable_version)->getMajor();
        return ($major - 1) . '.4';
    }

    /**
     * @param string $delimiter
     * @return string
     */
    public function getSupportedVersionsAsString(string $delimiter = '|'): string
    {
        return implode($delimiter, $this->supported_versions ?? []);
    }

    /**
     * @return int
     */
    public function getMaintainedVersionCount(): int
    {
        return count($this->maintained_versions);
    }

    /**
     * @param string $delimiter
     * @return string
     */
    public function getMaintainedVersionsAsString(string $delimiter = '|'): string
    {
        return implode($delimiter, $this->maintained_versions ?? []);
    }

    /**
     * @return SymfonyVersions|null
     */
    public function getSymfonyVersions(): ?SymfonyVersions
    {
        return $this->symfony_versions;
    }

    /**
     * @param SymfonyVersions|null $symfony_versions
     * @return $this
     */
    public function setSymfonyVersions(?SymfonyVersions $symfony_versions): self
    {
        $this->symfony_versions = $symfony_versions;
        return $this;
    }

    /**
     * @return $this
     */
    public function normalize(): self
    {
        $parser = new VersionParser();

        $this->setLatestStableVersion($parser->normalize($this->getLatestStableVersion()));

        $supportedVersions = [];
        foreach ($this->getSupportedVersions() as $supportedVersion) {
            $supportedVersions[] = $parser->normalize($supportedVersion);
        }
        
        $this->setSupportedVersions($supportedVersions);
        
        $maintainedVersions = [];
        foreach ($this->getMaintainedVersions() as $supportedVersion) {
            $maintainedVersions[] = $parser->normalize($supportedVersion);
        }
        
        $this->setMaintainedVersions($maintainedVersions);

        $securityMaintainedVersions = [];
        foreach ($this->getSecurityMaintainedVersions() as $supportedVersion) {
            $securityMaintainedVersions[] = $parser->normalize($supportedVersion);
        }
        
        $this->setSecurityMaintainedVersions($securityMaintainedVersions);

        $flexSupportedVersions = [];
        foreach ($this->getFlexSupportedVersions() as $supportedVersion) {
            $flexSupportedVersions[] = $parser->normalize($supportedVersion);
        }
        
        $this->setFlexSupportedVersions($flexSupportedVersions);

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLatestStableVersion(): ?string
    {
        return $this->latest_stable_version;
    }

    /**
     * @param string|null $latest_stable_version
     * @return $this
     */
    public function setLatestStableVersion(?string $latest_stable_version): self
    {
        $this->latest_stable_version = $latest_stable_version;
        return $this;
    }

    /**
     * @return string[]|null
     */
    public function getSupportedVersions(): ?array
    {
        return $this->supported_versions;
    }

    /**
     * @param string[]|null $supported_versions
     * @return $this
     */
    public function setSupportedVersions(?array $supported_versions): self
    {
        $this->supported_versions = $supported_versions;
        return $this;
    }

    /**
     * @return string[]|null
     */
    public function getMaintainedVersions(): ?array
    {
        return $this->maintained_versions;
    }

    /**
     * @param string[]|null $maintained_versions
     * @return $this
     */
    public function setMaintainedVersions(?array $maintained_versions): self
    {
        $this->maintained_versions = $maintained_versions;
        return $this;
    }

    /**
     * @return string[]|null
     */
    public function getSecurityMaintainedVersions(): ?array
    {
        return $this->security_maintained_versions;
    }

    /**
     * @param string[]|null $security_maintained_versions
     * @return $this
     */
    public function setSecurityMaintainedVersions(?array $security_maintained_versions): self
    {
        $this->security_maintained_versions = $security_maintained_versions;
        return $this;
    }

    /**
     * @return string[]|null
     */
    public function getFlexSupportedVersions(): ?array
    {
        return $this->flex_supported_versions;
    }

    /**
     * @param array|null $flex_supported_versions
     * @return $this
     */
    public function setFlexSupportedVersions(?array $flex_supported_versions): self
    {
        $this->flex_supported_versions = $flex_supported_versions;
        return $this;
    }
}
