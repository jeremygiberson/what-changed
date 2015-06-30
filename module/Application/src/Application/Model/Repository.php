<?php


namespace Application\Model;


use Zend\Stdlib\Hydrator\ObjectProperty;

class Repository
{
    /** @var  int */
    public $id;
    /** @var  string */
    public $url;

    public function toArray()
    {
        $hydrator = new ObjectProperty;
        return $hydrator->extract($this);
    }

    public function exchangeArray($data)
    {
        $hydrator = new ObjectProperty;
        $hydrator->hydrate($data, $this);
    }
}