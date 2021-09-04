<?php

namespace Koality\HealthFoundation\Result\Format\Ietf;

use Koality\HealthFoundation\Check\Check;
use Koality\HealthFoundation\Check\MetricAwareResult;
use Koality\HealthFoundation\Check\Result;
use Koality\HealthFoundation\Result\Format\Format;
use Koality\HealthFoundation\RunResult;

class IetfFormat implements Format
{
    const DEFAULT_OUTPUT_PASS = 'The health check was passed.';
    const DEFAULT_OUTPUT_WARN = 'Warning.';
    const DEFAULT_OUTPUT_FAIL = 'The health check failed.';

    private $passMessage = self::DEFAULT_OUTPUT_PASS;
    private $failMessage = self::DEFAULT_OUTPUT_FAIL;

    public function __construct($passMessage = null, $failMessage = null)
    {
        if ($passMessage) {
            $this->passMessage = $passMessage;
        }

        if ($failMessage) {
            $this->failMessage = $failMessage;
        }
    }

    public function handle(RunResult $runResult, $echoValue = true)
    {
        header('Content-Type: application/json');

        $output = $this->getOutput($runResult, $this->passMessage, $this->failMessage);

        $details = [];

        foreach ($runResult->getResults() as $resultArray) {
            /** @var Result $result */
            $result = $resultArray['result'];

            /** @var Check $check */
            $check = $resultArray['check'];


            if (is_string($resultArray['identifier'])) {
                $identifier = $resultArray['identifier'];
            } else {
                $identifier = $check->getIdentifier();
            }

            $details[$identifier] = [
                'status' => $result->getStatus(),
                'output' => $result->getMessage()
            ];

            $description = $resultArray['description'];
            if ($description) {
                $details[$identifier]['description'] = $description;
            }

            if ($result instanceof MetricAwareResult) {
                $details[$identifier]["observedValue"] = $result->getMetricValue();
                $details[$identifier]["observedUnit"] = $result->getMetricUnit();
            }
        }

        $resultArray = [
            'status' => $runResult->getStatus(),
            'output' => $output,
            'details' => $details
        ];

        echo json_encode($resultArray, JSON_PRETTY_PRINT);
    }

    private function getOutput(RunResult $runResult, $passMessage = null, $failMessage = null)
    {
        if ($runResult->getStatus() == Result::STATUS_PASS) {
            if (is_null($passMessage)) {
                $output = self::DEFAULT_OUTPUT_PASS;
            } else {
                $output = $passMessage;
            }
        } else {
            if (is_null($failMessage)) {
                $output = self::DEFAULT_OUTPUT_FAIL;
            } else {
                $output = $failMessage;
            }
        }

        return $output;
    }
}
