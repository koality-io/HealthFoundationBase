<?php

namespace Leankoala\HealthFoundationBase\test\Check;

use Leankoala\HealthFoundationBase\Check\Check;
use Leankoala\HealthFoundationBase\Check\Result;

class StaticStatusCheck implements Check
{
    private $status = Result::STATUS_FAIL;
    private $message = 'Static status fail.';

    public function init($status, $message)
    {
        $this->status = $status;
        $this->message = $message;
    }

    public function run()
    {
        return new Result($this->status, $this->message);
    }

    public function getIdentifier()
    {
        return 'test.check.staticStatus';
    }
}
