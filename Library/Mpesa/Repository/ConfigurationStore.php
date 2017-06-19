<?php

namespace Ignite\Finance\Library\Mpesa\Repository;
/**
 * Interface ConfigurationStore
 * @package Ignite\Finance\Library\Mpesa\Repository
 */
interface ConfigurationStore
{
    /**
     * @param $key
     * @param null $default
     * @return mixed
     */
    public function get($key, $default = null);
}