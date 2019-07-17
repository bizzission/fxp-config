<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Config\Tests\Fixtures\Cache;

use Fxp\Component\Config\Cache\AbstractCache;
use Fxp\Component\Config\ConfigCollectionInterface;
use Symfony\Component\Config\ConfigCacheFactoryInterface;
use Symfony\Component\HttpKernel\CacheWarmer\WarmableInterface;

/**
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class MockCache extends AbstractCache implements WarmableInterface
{
    /**
     * @var callable
     */
    private $factory;

    public function __construct(callable $factory, array $options = [])
    {
        parent::__construct($options);

        $this->factory = $factory;
    }

    public function warmUp($cacheDir): void
    {
        $this->getConfigCacheFactory();
    }

    public function getProtectedConfigCacheFactory(): ?ConfigCacheFactoryInterface
    {
        return $this->configCacheFactory;
    }

    /**
     * {@inheritdoc}
     *
     * @return ConfigCollectionInterface
     */
    public function createConfigurations(): ConfigCollectionInterface
    {
        return $this->loadConfigurationFromCache('prefix', function () {
            $factory = $this->factory;

            return $factory();
        });
    }
}
