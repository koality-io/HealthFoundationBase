<?php

namespace Leankoala\HealthFoundationBase\Filter;

use Leankoala\HealthFoundationBase\Check\Check;

abstract class BasicFilter implements Filter
{
    /**
     * @var Check
     */
    private $check;

    public function getIdentifier()
    {
        return $this->check->getIdentifier();
    }

    public function setCheck(Check $check)
    {
        $this->check = $check;
    }

    protected function getCheck()
    {
        return $this->check;
    }
}
