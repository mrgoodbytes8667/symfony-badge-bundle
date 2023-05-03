<?php


namespace Bytes\SymfonyBadge\Attribute;


use Attribute;
use Bytes\SymfonyBadge\Enums\Color;
use function Symfony\Component\String\u;

#[Attribute(Attribute::TARGET_CLASS_CONSTANT)]
class BadgeColor
{
    /**
     * @param int $color
     */
    public function __construct(private int $color)
    {
    }

    /**
     * @return int
     */
    public function getColor(): int
    {
        return $this->color;
    }

    /**
     * @param bool $prependHash
     * @return string
     */
    public function getHexColor(bool $prependHash = true): string
    {
        return u(dechex($this->getColor()))->padStart(6, '0')->slice(-6)->upper()->prepend($prependHash ? '#' : '')->upper();
    }
}
