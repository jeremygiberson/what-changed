<?php
/**
 * @category WebPT
 * @copyright Copyright (c) 2015 WebPT, INC
 * @author jgiberson
 * 6/30/15 9:59 AM
 */

namespace Application\Model;


use Zend\Stdlib\Hydrator\ObjectProperty;

abstract class AbstractModel
{
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