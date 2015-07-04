<?php

namespace Repo\Migrations;

use Zend\Db\Adapter\AdapterAwareInterface;
use Zend\Db\Adapter\AdapterAwareTrait;
use Zend\Db\Sql\Ddl\Column\Char;
use Zend\Db\Sql\Ddl\Column\Datetime;
use Zend\Db\Sql\Ddl\Column\Integer;
use Zend\Db\Sql\Ddl\Column\Text;
use Zend\Db\Sql\Ddl\Column\Varchar;
use Zend\Db\Sql\Ddl\Constraint\ForeignKey;
use Zend\Db\Sql\Ddl\Constraint\PrimaryKey;
use Zend\Db\Sql\Ddl\CreateTable;
use Zend\Db\Sql\Ddl\DropTable;
use ZfSimpleMigrations\Library\AbstractMigration;
use Zend\Db\Metadata\MetadataInterface;

class Version20150630161554 extends AbstractMigration implements AdapterAwareInterface
{
    use AdapterAwareTrait;

    public static $description = "Add commit log tables";

    public function up(MetadataInterface $schema)
    {
        $create_commit = new CreateTable('commit');
        $create_commit->addColumn(new Integer('commit_id'));
        $create_commit->addConstraint(new PrimaryKey('commit_id'));
        $create_commit->addColumn(new Integer('repository_id'));
        $create_commit->addConstraint(new ForeignKey('fk_repository', 'repository_id', 'repository', 'id'));
        $create_commit->addColumn(new Varchar('commit_hash', 40));
        $create_commit->addColumn(new Datetime('commit_date'));
        $create_commit->addColumn(new Varchar('commit_author', 48, true));
        $create_commit->addColumn(new Text('commit_message'));
        $this->addSql($create_commit->getSqlString($this->adapter->getPlatform()));

        $create_commit_file_status = new CreateTable('commit_file_status');
        $create_commit_file_status->addColumn(new Integer('commit_file_status_id'));
        $create_commit_file_status->addConstraint(new Primarykey('commit_file_status_id'));
        $create_commit_file_status->addColumn(new Integer('commit_id'));
        $create_commit_file_status->addConstraint(new ForeignKey('fk_commit', 'commit_id', 'commit', 'commit_id'));
        $create_commit_file_status->addColumn(new Char('status', 1));
        $create_commit_file_status->addColumn(new Varchar('name', 512));
        $this->addSql($create_commit_file_status->getSqlString($this->adapter->getPlatform()));
    }

    public function down(MetadataInterface $schema)
    {
        $drop_commit_file_status = new DropTable('commit_file_status');
        $this->addSql($drop_commit_file_status->getSqlString($this->adapter->getPlatform()));

        $drop_commit = new DropTable('commit');
        $this->addSql($drop_commit->getSqlString($this->adapter->getPlatform()));
    }
}
