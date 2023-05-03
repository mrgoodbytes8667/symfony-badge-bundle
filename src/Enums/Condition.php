<?php

namespace Bytes\SymfonyBadge\Enums;

use Bytes\EnumSerializerBundle\Enums\StringBackedEnumInterface;
use Bytes\EnumSerializerBundle\Enums\StringBackedEnumTrait;

enum Condition: string implements StringBackedEnumInterface
{
    use StringBackedEnumTrait;

    case SYMFONY = 'symfony';
    case SYMFONY_TEST = 'symfony-test';
    case LTS = 'lts';
    case STABLE = 'stable';
    case DEV = 'dev';
}
