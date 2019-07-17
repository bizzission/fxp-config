<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Config;

/**
 * The abstract class of annotation loader.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class ConfigResource
{
    /**
     * @var mixed
     */
    private $resource;

    /**
     * @var null|string
     */
    private $type;

    /**
     * Constructor.
     *
     * @param mixed       $resource The resource
     * @param null|string $type     The resource type
     */
    public function __construct($resource, ?string $type = null)
    {
        $this->resource = $resource;
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->resource.(null !== $this->type ? sprintf(' [%s])', $this->type) : '');
    }

    /**
     * Get the resource.
     *
     * @return mixed
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * Get the resource type.
     *
     * @return null|string
     */
    public function getType(): ?string
    {
        return $this->type;
    }
}
