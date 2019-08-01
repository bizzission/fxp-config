<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Config\Tests\Fixtures\Annotation;

/**
 * @author François Pluchino <francois.pluchino@gmail.com>
 * @Annotation
 */
class MockArrayAnnotation extends MockAnnotation
{
    public function allowArray(): bool
    {
        return true;
    }
}
