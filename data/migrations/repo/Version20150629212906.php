<?php

namespace Repo\Migrations;

use Zend\Db\Adapter\AdapterAwareInterface;
use Zend\Db\Adapter\AdapterAwareTrait;
use Zend\Db\Sql\Ddl\Column\Integer;
use Zend\Db\Sql\Ddl\Column\Varchar;
use Zend\Db\Sql\Ddl\Constraint\PrimaryKey;
use Zend\Db\Sql\Ddl\CreateTable;
use Zend\Db\Sql\Ddl\DropTable;
use ZfSimpleMigrations\Library\AbstractMigration;
use Zend\Db\Metadata\MetadataInterface;

class Version20150629212906 extends AbstractMigration implements AdapterAwareInterface
{
    use AdapterAwareTrait;

    public static $description = "Migration description";

    public function up(MetadataInterface $schema)
    {
        $create_repositories = new CreateTable('repository');
        $create_repositories->addColumn(new Integer('id'));
        $create_repositories->addConstraint(new PrimaryKey('id'));
        $create_repositories->addColumn(new Varchar('url', 128));
        $this->addSql($create_repositories->getSqlString($this->adapter->getPlatform()));
    }

    public function down(MetadataInterface $schema)
    {
        $drop_repositories = new DropTable('repository');
        $this->addSql($drop_repositories->getSqlString($this->adapter->getPlatform()));
    }
}
