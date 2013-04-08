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

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Options factory.
 *
 * @author Gordon Schmidt <schmidt.gordon@web.de>
 */
class OptionsFactory implements FactoryInterface
{
    /**
     * Create options from configuration
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return stdClass
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');
        return $this->parseConfig($config['zf2_github_api']);
    }

    /**
     * parse configuration and convert it into stdClass
     *
     * @param mixed $config
     * @return mixed
     */
    protected function parseConfig($config)
    {
        if(!is_array($config)) {
            return $config;
        }
        $result = new \stdClass();
        foreach ($config as $key => $value) {
            $subKeys = explode('.', $key, 2);
            $mainKey = trim($subKeys[0]);
            if (is_string($mainKey) && !empty($mainKey)) {
                $mainKey = preg_replace_callback(
                    '/_(.)/',
                    function($m) { return strtoupper($m[1]); },
                    $mainKey
                );
                if (isset($subKeys[1])) {
                    $value = $this->parseConfig(array($subKeys[1] => $value));
                    if (isset($result->$mainKey) && is_object($result->$mainKey)) {
                         $result->$mainKey = (object)array_merge((array)$result->$mainKey, (array)$value);
                    } else {
                         $result->$mainKey = $value;
                    }
                } else {
                    $result->$mainKey = $this->parseConfig($value);
                }
            }
        }
        return $result;
    }
}
