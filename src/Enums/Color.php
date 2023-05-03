<?php

namespace Bytes\SymfonyBadge\Enums;

use Bytes\EnumSerializerBundle\Enums\StringBackedEnumInterface;
use Bytes\EnumSerializerBundle\Enums\StringBackedEnumTrait;
use Bytes\SymfonyBadge\Attribute\BadgeColor;
use ReflectionEnum;
use function Symfony\Component\String\u;

enum Color: string implements StringBackedEnumInterface
{
    use StringBackedEnumTrait;

    #[BadgeColor(0x44cc11)]
    case BRIGHTGREEN = 'brightgreen';
    #[BadgeColor(0x97ca00)]
    case GREEN = 'green';
    #[BadgeColor(0xa4a61d)]
    case YELLOWGREEN = 'yellowgreen';
    #[BadgeColor(0xdfb317)]
    case YELLOW = 'yellow';
    #[BadgeColor(0xfe7d37)]
    case ORANGE = 'orange';
    #[BadgeColor(0xe05d44)]
    case RED = 'red';
    #[BadgeColor(0x007ec6)]
    case BLUE = 'blue';
    #[BadgeColor(0x9f9f9f)]
    case LIGHTGREY = 'lightgrey';

    #[BadgeColor(0x44cc11)]
    case SUCCESS = 'success';
    #[BadgeColor(0xfe7d37)]
    case IMPORTANT = 'important';
    #[BadgeColor(0xe05d44)]
    case CRITICAL = 'critical';
    #[BadgeColor(0x007ec6)]
    case INFORMATIONAL = 'informational';
    #[BadgeColor(0x9f9f9f)]
    case INACTIVE = 'inactive';

    /**
     * @param bool $prependHash
     * @return string
     */
    public function getHexColor(bool $prependHash = true): string
    {
        /** @var BadgeColor|null $attribute */
        $attribute = $this->getAttribute(BadgeColor::class);
        return $attribute?->getHexColor(prependHash: $prependHash) ?? '';
    }
}
