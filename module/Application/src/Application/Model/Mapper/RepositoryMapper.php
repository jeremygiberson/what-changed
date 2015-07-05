<?php


namespace Application\Model\Mapper;


use Application\Model\Repository;

class RepositoryMapper extends AbstractMapper
{
    /**
     * @param Repository $model
     */
    public function save(Repository $model)
    {
        $this->internalSave($model);
    }

    /**
     * @param string $url
     * @return null|Repository
     */
    public function findByUrl($url)
    {
        return $this->getTableGateway()->select(['url' => $url])->current();
    }

    /**
     * @param int $id
     * @return null|Repository
     */
    public function findById($id)
    {
        return $this->getTableGateway()->select(['id' => $id])->current();
    }
}