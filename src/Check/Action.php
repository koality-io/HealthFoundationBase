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

    private $group;

    private $identifier;

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

    /**
     * @param string $identifier
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
    }

    /**
     * @return mixed
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * @param mixed $group
     */
    public function setGroup($group)
    {
        $this->group = $group;
    }

    public function asArray()
    {
        $array = [
            'type' => $this->type,
            'label' => $this->label,
            'url' => $this->url
        ];

        if ($this->identifier) {
            $array['identifier'] = $this->identifier;
        }

        if ($this->group) {
            $array['group'] = $this->group;
        }

        return $array;
    }
}
