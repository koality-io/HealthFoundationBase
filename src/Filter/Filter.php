<?php

namespace Leankoala\HealthFoundationBase\Filter;

use Leankoala\HealthFoundationBase\Check\Check;

interface Filter extends Check
{
    public function setCheck(Check $check);
}
