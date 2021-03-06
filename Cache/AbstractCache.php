<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Config\Cache;

use Fxp\Component\Config\ConfigCollectionInterface;
use Symfony\Component\Config\ConfigCacheFactory;
use Symfony\Component\Config\ConfigCacheFactoryInterface;
use Symfony\Component\Config\ConfigCacheInterface;

/**
 * Base of cache.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
abstract class AbstractCache
{
    /**
     * @var array
     */
    protected $options = [
        'cache_dir' => null,
        'debug' => false,
    ];

    /**
     * @var null|ConfigCacheFactoryInterface
     */
    protected $configCacheFactory;

    /**
     * Constructor.
     *
     * @param array $options An array of options
     */
    public function __construct(array $options = [])
    {
        $this->options = array_merge($this->options, $options);
    }

    /**
     * Set the config cache factory.
     *
     * @param ConfigCacheFactoryInterface $configCacheFactory The config cache factory
     */
    public function setConfigCacheFactory(ConfigCacheFactoryInterface $configCacheFactory): void
    {
        $this->configCacheFactory = $configCacheFactory;
    }

    /**
     * Provides the ConfigCache factory implementation, falling back to a
     * default implementation if necessary.
     *
     * @return ConfigCacheFactoryInterface
     */
    protected function getConfigCacheFactory(): ConfigCacheFactoryInterface
    {
        if (!$this->configCacheFactory) {
            $this->configCacheFactory = new ConfigCacheFactory($this->options['debug']);
        }

        return $this->configCacheFactory;
    }

    /**
     * Load the configurations from cache.
     *
     * @param string   $name              The file cache name
     * @param callable $getConfigurations The callable to retrieve the configurations
     *
     * @return ConfigCollectionInterface
     */
    protected function loadConfigurationFromCache($name, callable $getConfigurations): ConfigCollectionInterface
    {
        $cache = $this->getConfigCacheFactory()->cache(
            $this->options['cache_dir'].'/'.$name.'_configs.php',
            function (ConfigCacheInterface $cache) use ($getConfigurations): void {
                /** @var ConfigCollectionInterface $configs */
                $configs = $getConfigurations();
                $content = sprintf(
                    'unserialize(%s)',
                    var_export(serialize($configs), true)
                );

                $cache->write($this->getContent($content), $configs->getResources());
            }
        );

        return require $cache->getPath();
    }

    /**
     * @param string $content The content
     *
     * @return string
     */
    protected function getContent(string $content): string
    {
        return sprintf(
            <<<'EOF'
<?php

return %s;

EOF
            ,
            $content
        );
    }
}
