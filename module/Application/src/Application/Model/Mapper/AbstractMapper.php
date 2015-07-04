<?php
/**
 * @category WebPT
 * @copyright Copyright (c) 2015 WebPT, INC
 * @author jgiberson
 * 6/30/15 3:12 PM
 */

namespace Application\Model\Mapper;


use Application\Model\AbstractModel;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\AdapterAwareInterface;
use Zend\Db\Adapter\AdapterAwareTrait;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

abstract class AbstractMapper implements AdapterAwareInterface
{
    use AdapterAwareTrait;
    /** @var  TableGateway */
    private $tableGateway;
    /** @var  string */
    private $primaryKey;

    /**
     * @return string
     */
    public function getPrimaryKey()
    {
        return $this->primaryKey;
    }

    /**
     * @return TableGateway
     */
    public function getTableGateway()
    {
        return $this->tableGateway;
    }

    /**
     * @param Adapter $adapter
     * @param $tableName
     * @param string $primaryKey
     * @param null $prototypeInstance
     */
    public function __construct(Adapter $adapter, $tableName, $primaryKey = 'id', $prototypeInstance = null)
    {
        $this->setDbAdapter($adapter);

        if($prototypeInstance)
        {
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype($prototypeInstance);
        } else {
            $resultSetPrototype = null;
        }


        $this->tableGateway = new TableGateway($tableName,
            $adapter,
            null,
            $resultSetPrototype);

        $this->primaryKey = $primaryKey;
    }

    /**
     * @param AbstractModel $model
     */
    protected function internalSave(AbstractModel $model)
    {
        $pKey = $this->getPrimaryKey();

        if(isset($model->id))
        {
            $this->tableGateway->update($model->toArray(), [$pKey => $model->{$pKey}]);
        } else {
            $this->tableGateway->insert($model->toArray());
            $id = $this->tableGateway->getLastInsertValue();
            $model->{$pKey} = $id;
        }
    }

}