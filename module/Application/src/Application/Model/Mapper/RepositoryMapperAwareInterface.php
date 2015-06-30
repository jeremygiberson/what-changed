<?php


namespace Application\Model\Mapper;


interface RepositoryMapperAwareInterface
{
    /**
     * @param RepositoryMapper $mapper
     */
    public function setRepositoryMapper(RepositoryMapper $mapper);

    /**
     * @return RepositoryMapper
     */
    public function getRepositoryMapper();
}