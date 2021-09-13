<?php


namespace Leankoala\HealthFoundationBase\Check;

/**
 * Class Action
 *
 * @package Leankoala\HealthFoundationBase\Check
 *
 * @author Nils Langner <nils.langner@leankoala.com>
 * created 2021-09-13
 */
class Action
{
    const TYPE_LINK = 'link';
    const TYPE_REST = 'rest';

    private $label;
    private $url;
    private $type;

    /**
     * @param $label
     * @param $url
     * @param $type
     */
    public function __construct($label, $url, $type = self::TYPE_LINK)
    {
        $this->label = $label;
        $this->url = $url;
        $this->type = $type;
    }

    public function asArray()
    {
        return [
            'type' => $this->type,
            'label' => $this->label,
            'url' => $this->url
        ];
    }
}
