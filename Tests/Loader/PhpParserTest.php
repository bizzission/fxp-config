<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Config\Tests\Loader;

use Fxp\Component\Config\Loader\PhpParser;
use Fxp\Component\Config\Tests\Fixtures\Model\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @author François Pluchino <francois.pluchino@gmail.com>
 *
 * @internal
 */
final class PhpParserTest extends TestCase
{
    public function testExtractClasses(): void
    {
        $ref = new \ReflectionClass(MockObject::class);

        $classes = PhpParser::extractClasses($ref->getFileName());
        $expected = [
            MockObject::class,
        ];

        static::assertSame($expected, $classes);
    }
}
