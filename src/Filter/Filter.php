<?php

namespace Koality\HealthFoundation\Filter;

use Koality\HealthFoundation\Check\Check;

interface Filter extends Check
{
    public function setCheck(Check $check);
}
