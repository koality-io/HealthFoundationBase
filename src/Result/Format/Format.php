<?php

namespace Koality\HealthFoundation\Result\Format;

use Koality\HealthFoundation\RunResult;

interface Format
{
    public function handle(RunResult $runResult, $echoValue = true);
}
