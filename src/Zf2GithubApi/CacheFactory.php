<?php
/**
 * This file is part of Zf2GithubApi.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Copyright (c) 2013 Gordon Schmidt
 * @license   MIT
 */

namespace Zf2GithubApi;

use Github\HttpClient\Cache\CacheInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zf2GithubApi\Exception\InvalidArgumentException;

/**
 * Cache factory.
 *
 * @author Gordon Schmidt <schmidt.gordon@web.de>
 */
class CacheFactory implements FactoryInterface
{
    /**
     * Create cache
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return CacheInterface
     * @throws InvalidArgumentException
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $options = $serviceLocator->get('zf2_github_api.options');
        $cacheClass = '\Github\HttpClient\Cache\FilesystemCache';
        $cacheParams = array();
        if (isset($options->cache) && count($options->cache)) {
            if (isset($options->cache->class)) {
                $cacheClass = $options->cache->class;
            }
            if (isset($options->cache->params)) {
                $cacheParams = (array)$options->cache->params;
            }
        }
        $class = new \ReflectionClass($cacheClass);
        if (!$class->implementsInterface('\Github\HttpClient\Cache\CacheInterface')) {
            throw new InvalidArgumentException('configuration error: "cache.class" '
                . 'has to implement \Github\HttpClient\Cache\CacheInterface');
        }
        try {
            $cache = $class->newInstanceArgs($cacheParams);
        } catch (\ReflectionException $e) {
            throw new InvalidArgumentException('configuration error: "cache.params" '
                . 'have to be valid constructor params for "cache.class" and the '
                . 'constructor has to be public');
        }
        return $cache;
    }
}
