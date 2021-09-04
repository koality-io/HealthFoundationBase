<?php

namespace Leankoala\HealthFoundationBase\Check;

use Leankoala\HealthFoundationBase\Extenstion\Cache\Cache;

interface CacheAwareCheck extends Check
{
    public function setCache(Cache $cache);
}
