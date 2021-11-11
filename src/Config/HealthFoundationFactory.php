<?php

namespace Leankoala\HealthFoundationBase\Config;

use Leankoala\HealthFoundationBase\Check\Check;
use Leankoala\HealthFoundationBase\Filter\Filter;
use Leankoala\HealthFoundationBase\HealthFoundation;
use PhmLabs\Components\Init\Init;

class HealthFoundationFactory
{
    public static function from($configArray)
    {
        if (!is_array($configArray)) {
            throw new \RuntimeException('The given value is not an array.');
        }

        $healthFoundation = new HealthFoundation();

        if (!array_key_exists('checks', $configArray)) {
            throw new \RuntimeException('The mandatory config element "checks" is missing.');
        }

        $healthFoundation = self::initChecks($configArray, $healthFoundation);

        return $healthFoundation;
    }

    /**
     * @param array $configArray
     *
     * @return HealthFoundation
     */
    private static function initChecks($configArray, HealthFoundation $healthFoundation)
    {
        foreach ($configArray['checks'] as $key => $checkArray) {

            /** @var Check $check */
            $check = Init::initialize($checkArray, 'check');

            if (array_key_exists('description', $checkArray)) {
                $description = $checkArray['description'];
            } else {
                $description = "";
            }

            if (array_key_exists('identifier', $checkArray)) {
                $identifier = $checkArray['identifier'];
            } else {
                $identifier = $key;
            }

            if (array_key_exists('filter', $checkArray)) {
                foreach ($checkArray['filter'] as $decorator) {
                    $decorator = Init::initialize($decorator, 'filter');

                    if ($decorator instanceof Filter) {
                        $decorator->setCheck($check);
                        $check = $decorator;
                    } else {
                        throw new \RuntimeException('The given decorator must implement the decorator interface.');
                    }
                }
            }

            $healthFoundation->registerCheck($check, $identifier, $description);
        }

        return $healthFoundation;
    }
}
