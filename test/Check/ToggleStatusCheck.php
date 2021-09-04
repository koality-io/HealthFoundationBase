<?php

namespace Leankoala\HealthFoundationBase\test\Check;

use Leankoala\HealthFoundationBase\Check\Check;
use Leankoala\HealthFoundationBase\Check\CacheAwareCheck;
use Leankoala\HealthFoundationBase\Check\Result;
use Leankoala\HealthFoundationBase\Extenstion\Cache\Cache;

class ToggleStatusCheck implements Check, CacheAwareCheck
{
    /**
     * @var Cache
     */
    private $cache;

    public function setCache(Cache $cache)
    {
        $this->cache = $cache;
    }

    public function run()
    {
        $lastStatus = $this->cache->get('status');

        if ($lastStatus === Result::STATUS_FAIL) {
            $this->cache->set('status', Result::STATUS_PASS);
            return new Result(Result::STATUS_PASS, 'Toggle to pass');
        } else {
            $this->cache->set('status', Result::STATUS_FAIL);
            return new Result(Result::STATUS_FAIL, 'Toggle to fail');
        }
    }

    public function getIdentifier()
    {
        return 'test.check.toggleNumber';
    }
}
