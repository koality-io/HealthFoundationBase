<?php

namespace Leankoala\HealthFoundationBase;

use GuzzleHttp\Client;
use Leankoala\HealthFoundationBase\Check\Check;
use Leankoala\HealthFoundationBase\Check\HttpClientAwareCheck;
use Leankoala\HealthFoundationBase\Check\CacheAwareCheck;
use Leankoala\HealthFoundationBase\Extenstion\Cache\Cache;

class HealthFoundation
{
    /**
     * @var Check[]
     */
    private $registeredChecks = [];

    /**
     * @var Client
     */
    private $httpClient;

    /**
     * @param Client $httpClient
     */
    public function setHttpClient(Client $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * Return the current httpClient if set otherwise create one.
     *
     * @return Client
     */
    private function getHttpClient()
    {
        if (!$this->httpClient) {
            $this->httpClient = new Client();
        }

        return $this->httpClient;
    }

    /**
     * Return the current cache abstraction
     *
     * @return Cache
     */
    private function getCache(CacheAwareCheck $check)
    {
        return new Cache($check->getIdentifier());
    }

    public function registerCheck(Check $check, $identifier = false, $description = "", $group = "")
    {
        if ($check instanceof HttpClientAwareCheck) {
            $check->setHttpClient($this->getHttpClient());
        }

        if ($check instanceof CacheAwareCheck) {
            $check->setCache($this->getCache($check));
        }

        if ($identifier) {
            $this->registeredChecks[$identifier] = ['check' => $check, 'description' => $description, 'group' => $group];
        } else {
            $this->registeredChecks[] = ['check' => $check, 'description' => $description, 'group' => $group];
        }
    }

    public function runHealthCheck()
    {
        $runResult = new RunResult();

        foreach ($this->registeredChecks as $identifier => $checkInfos) {
            /** @var Check $check */
            $check = $checkInfos['check'];
            $group = $checkInfos['group'];

            $checkResult = $check->run();
            $runResult->addResult($check, $checkResult, $identifier, $checkInfos['description'], $group);
        }

        return $runResult;
    }

}
