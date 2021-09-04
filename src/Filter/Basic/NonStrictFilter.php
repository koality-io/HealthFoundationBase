<?php

namespace Koality\HealthFoundation\Filter\Basic;

use Koality\HealthFoundation\Check\CacheAwareCheck;
use Koality\HealthFoundation\Check\MetricAwareResult;
use Koality\HealthFoundation\Check\Result;
use Koality\HealthFoundation\Filter\BasicFilter;
use Koality\HealthFoundation\Extenstion\Cache\Cache;

class NonStrictFilter extends BasicFilter implements CacheAwareCheck
{
    private $maxErrorsInARow = 2;

    /**
     * @var Cache
     */
    private $cache;

    public function init($maxErrorsInARow = 2)
    {
        $this->maxErrorsInARow = $maxErrorsInARow;
    }

    public function run()
    {
        $result = $this->getCheck()->run();

        // @todo handle metric aware checks

        if ($result->getStatus() == Result::STATUS_FAIL) {
            $currentErrorsInARow = (int)$this->cache->get('errorsInARow');
            $currentErrorsInARow++;

            $this->cache->set('errorsInARow', $currentErrorsInARow);

            if ($currentErrorsInARow >= $this->maxErrorsInARow) {
                return $result;
            } else {
                if ($result instanceof MetricAwareResult) {
                    $metricResult = new MetricAwareResult(Result::STATUS_PASS, 'Passed because non-strict mode is activated. Failed with message: ' . $result->getMessage());
                    $metricResult->setMetric($result->getMetricValue(), $result->getMetricUnit());
                    return $metricResult;
                } else {
                    return new Result(Result::STATUS_PASS, 'Passed because non-strict mode is activated. Failed with message: ' . $result->getMessage());
                }
            }
        } else {
            $this->cache->set('errorsInARow', 0);
            return $result;
        }
    }

    public function setCache(Cache $cache)
    {
        $this->cache = $cache;
    }
}
