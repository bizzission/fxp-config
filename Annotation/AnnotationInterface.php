<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Config\Annotation;

/**
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
interface AnnotationInterface
{
    /**
     * Returns the alias name for an annotated configuration.
     *
     * @return null|string
     */
    public function getAliasName(): ?string;

    /**
     * Returns whether multiple annotations of this type are allowed.
     *
     * @return bool
     */
    public function allowArray(): bool;
}
