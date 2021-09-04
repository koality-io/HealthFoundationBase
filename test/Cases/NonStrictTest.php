<?php

include_once __DIR__ . '/../../../vendor/autoload.php';

$foundation = new \Koality\HealthFoundation\HealthFoundation();

$staticCheck = new \Koality\HealthFoundation\test\Check\StaticStatusCheck();

$nonStrictStaticCheck = new \Koality\HealthFoundation\Filter\Basic\NonStrictFilter();
$nonStrictStaticCheck->setCheck($staticCheck);

$foundation->registerCheck($nonStrictStaticCheck, null, 'Test non-strict mode for static check.');

$runResult = $foundation->runHealthCheck();

$formatter = new \Koality\HealthFoundation\Result\Format\Ietf\IetfFormat(
    'pass',
    'fail'
);

$formatter->handle($runResult);
