<?php

include_once __DIR__ . '/../../../vendor/autoload.php';

$foundation = new \Leankoala\HealthFoundationBase\HealthFoundation();

$staticCheck = new \Leankoala\HealthFoundationBase\test\Check\StaticStatusCheck();

$nonStrictStaticCheck = new \Leankoala\HealthFoundationBase\Filter\Basic\NonStrictFilter();
$nonStrictStaticCheck->setCheck($staticCheck);

$foundation->registerCheck($nonStrictStaticCheck, null, 'Test non-strict mode for static check.');

$runResult = $foundation->runHealthCheck();

$formatter = new \Leankoala\HealthFoundationBase\Result\Format\Ietf\IetfFormat(
    'pass',
    'fail'
);

$formatter->handle($runResult);
