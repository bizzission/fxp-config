<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Config\Tests\Annotation;

use Fxp\Component\Config\Exception\RuntimeException;
use Fxp\Component\Config\Tests\Fixtures\Annotation\MockAnnotation;
use PHPUnit\Framework\TestCase;

/**
 * @author François Pluchino <francois.pluchino@gmail.com>
 *
 * @internal
 */
final class AbstractAnnotationTest extends TestCase
{
    public function testAnnotationConfig(): void
    {
        $mock = new MockAnnotation([
            'foo' => 'bar',
        ]);

        static::assertSame('bar', $mock->getFoo());
    }

    public function testAnnotationConfigWithInvalidKey(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Unknown key "bar" for annotation "@Fxp\Component\Config\Tests\Fixtures\Annotation\MockAnnotation');

        new MockAnnotation([
            'bar' => 'foo',
        ]);
    }
}
