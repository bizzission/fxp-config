<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Config\Loader;

use Doctrine\Common\Annotations\Reader;
use Symfony\Component\Config\Loader\Loader;

/**
 * The abstract class of annotation loader.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
abstract class AbstractAnnotationLoader extends Loader
{
    /**
     * @var Reader
     */
    protected $reader;

    /**
     * Constructor.
     *
     * @param Reader $reader The annotation reader
     */
    public function __construct(Reader $reader)
    {
        $this->reader = $reader;
    }
}
