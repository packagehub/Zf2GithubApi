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

use Github\HttpClient\HttpClientInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zf2GithubApi\Exception\InvalidArgumentException;

/**
 * Http client factory.
 *
 * @author Gordon Schmidt <schmidt.gordon@web.de>
 */
class HttpFactory implements FactoryInterface
{
    /**
     * Create http client
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return HttpClientInterface
     * @throws InvalidArgumentException
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $options = $serviceLocator->get('zf2_github_api.options');
        $httpClientParams = isset($options->httpClient->params) ? (array)$options->httpClient->params : array();
        $useCache = (isset($options->cache->enabled) && true == $options->cache->enabled);
        if (isset($options->httpClient->class)) {
            $httpClientClass = $options->httpClient->class;
        } else {
            if ($useCache) {
                $httpClientClass = '\Github\HttpClient\CachedHttpClient';
            } else {
                $httpClientClass = '\Github\HttpClient\HttpClient';
            }
        }
        $class = new \ReflectionClass($httpClientClass);
        $httpClient = $class->newInstanceArgs($httpClientParams);
        if (!$httpClient instanceof HttpClientInterface) {
            throw new InvalidArgumentException('configuration error: ' . "'http_client.class'"
                . 'has to implement \Github\HttpClient\HttpClientInterface');
        }

        // set http client cache if used
        if ($useCache && method_exists($httpClient, 'setCache')) {
            $cache = $serviceLocator->get('zf2_github_api.cache');
            $httpClient->setCache($cache);
        }
        return $httpClient;
    }
}
