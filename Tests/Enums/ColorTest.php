<?php

namespace Bytes\SymfonyBadge\Tests\Enums;

use Bytes\SymfonyBadge\Enums\Color;
use Generator;
use PHPUnit\Framework\TestCase;


class ColorTest extends TestCase
{
    /**
     * @return Generator
     */
    public static function provideColorCases(): Generator
    {
        foreach (Color::cases() as $case) {
            yield $case->name => [$case];
        }
    }

    /**
     * @dataProvider provideColorCases
     * @param Color $color
     * @return void
     */
    public function testColorsHexColors($color)
    {
        $hexColor = $color->getHexColor();
        self::assertStringStartsWith('#', $hexColor);
        self::assertEquals(7, strlen($hexColor));
        self::assertNotEquals($hexColor, strtolower($hexColor)); // This only works currently because all current color codes have letters

        $hexColor = $color->getHexColor(prependHash: false);
        self::assertStringStartsNotWith('#', $hexColor);
        self::assertEquals(6, strlen($hexColor));
        self::assertNotEquals($hexColor, strtolower($hexColor)); // This only works currently because all current color codes have letters
    }

    /**
     * @return void
     */
    public function testGreenSuccess()
    {
        $green = Color::BRIGHTGREEN;
        $success = Color::SUCCESS;
        self::assertInstanceOf(Color::class, $green);
        self::assertInstanceOf(Color::class, $success);
        self::assertNotEquals($success, $green);
        self::assertEquals('#44CC11', $green->getHexColor());
        self::assertEquals($success->getHexColor(), $green->getHexColor());
    }
}
