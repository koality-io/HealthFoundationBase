<?php

namespace Leankoala\HealthFoundationBase\Result\Format;

use Leankoala\HealthFoundationBase\RunResult;

interface Format
{
    public function handle(RunResult $runResult, $echoValue = true);
}
