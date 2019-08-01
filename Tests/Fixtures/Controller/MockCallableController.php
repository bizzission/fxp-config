<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Config\Tests\Fixtures\Controller;

use Fxp\Component\Config\Tests\Fixtures\Annotation\MockAnnotation;

/**
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class MockCallableController
{
    /**
     * @MockAnnotation
     */
    public function __invoke(): void
    {
    }
}
