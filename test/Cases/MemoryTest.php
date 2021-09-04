<?php

include_once __DIR__ . '/../../../vendor/autoload.php';

$foundation = new \Koality\HealthFoundation\HealthFoundation();

$toggleCheck = new \Koality\HealthFoundation\test\Check\ToggleStatusCheck();

$foundation->registerCheck($toggleCheck, null, 'Test memory by toggling the check pass/fail.');

$runResult = $foundation->runHealthCheck();

$formatter = new \Koality\HealthFoundation\Result\Format\Ietf\IetfFormat(
    'pass',
    'fail'
);

$formatter->handle($runResult);
