<?php

namespace Leankoala\HealthFoundationBase\Check;

interface Check
{
    /**
     * Check a single characteristic
     *
     * @return Result
     */
    public function run();

    public function getIdentifier();
}
