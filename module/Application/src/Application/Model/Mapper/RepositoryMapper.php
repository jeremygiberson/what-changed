<?php


namespace Application\Model\Mapper;


use Application\Model\Repository;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\AdapterAwareInterface;
use Zend\Db\Adapter\AdapterAwareTrait;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class RepositoryMapper implements AdapterAwareInterface
{
    use AdapterAwareTrait;
    /** @var  TableGateway */
    protected $tableGateway;

    /**
     * RepositoryMapper constructor.
     */
    public function __construct(Adapter $adapter, $tableName)
    {
        $this->setDbAdapter($adapter);

        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Repository());

        $this->tableGateway = new TableGateway($tableName,
            $adapter,
            null,
            $resultSetPrototype);
    }

    /**
     * @param Repository $model
     */
    public function save(Repository $model)
    {
        if(isset($model->id))
        {
            $this->tableGateway->update($model->toArray(), ['id' => $model->id]);
        } else {
            $id = $this->tableGateway->insert($model->toArray());
            $model->id = $id;
        }
    }

    /**
     * @param string $url
     * @return null|Repository
     */
    public function findByUrl($url)
    {
        return $this->tableGateway->select(['url' => $url])->current();
    }
}