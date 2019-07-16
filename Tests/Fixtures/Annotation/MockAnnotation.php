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

use Fxp\Component\Config\Annotation\AbstractAnnotation;

/**
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class MockAnnotation extends AbstractAnnotation
{
    /**
     * @var null|string
     */
    protected $foo;

    public function setFoo(?string $foo): self
    {
        $this->foo = $foo;

        return $this;
    }

    public function getFoo(): ?string
    {
        return $this->foo;
    }
}
