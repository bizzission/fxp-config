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

use Doctrine\Common\Annotations\Reader;
use Fxp\Component\Config\Loader\AbstractAnnotationLoader;
use Fxp\Component\Config\Loader\ClassFinder;
use PHPUnit\Framework\TestCase;

/**
 * @author François Pluchino <francois.pluchino@gmail.com>
 *
 * @internal
 */
final class AbstractAnnotationLoaderTest extends TestCase
{
    /**
     * @throws
     */
    public function testConstructor(): void
    {
        /** @var Reader $reader */
        $reader = $this->getMockBuilder(Reader::class)->getMock();
        $classFinder = new ClassFinder();

        $loader = $this->getMockForAbstractClass(AbstractAnnotationLoader::class, [$reader, $classFinder]);

        static::assertInstanceOf(AbstractAnnotationLoader::class, $loader);
    }
}
