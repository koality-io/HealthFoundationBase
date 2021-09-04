<?php

namespace Leankoala\HealthFoundationBase\Check;

use GuzzleHttp\Client;

interface HttpClientAwareCheck
{
    public function setHttpClient(Client $client);
}
