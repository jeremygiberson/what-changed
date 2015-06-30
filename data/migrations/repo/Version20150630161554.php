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
        $create_commit_log = new CreateTable('commit_log');
        $create_commit_log->addColumn(new Integer('commit_log_id'));
        $create_commit_log->addConstraint(new PrimaryKey('commit_log_id'));
        $create_commit_log->addColumn(new Integer('repository_id'));
        $create_commit_log->addConstraint(new ForeignKey('fk_repository', 'repository_id', 'repository', 'id'));
        $create_commit_log->addColumn(new Varchar('commit_hash', 40));
        $create_commit_log->addColumn(new Datetime('commit_date'));
        $create_commit_log->addColumn(new Varchar('commit_author', 48, true));
        $create_commit_log->addColumn(new Text('commit_message'));
        $this->addSql($create_commit_log->getSqlString($this->adapter->getPlatform()));

        $create_commit_file_status = new CreateTable('commit_file_status');
        $create_commit_file_status->addColumn(new Integer('commit_file_status_id'));
        $create_commit_file_status->addConstraint(new Primarykey('commit_file_status_id'));
        $create_commit_file_status->addColumn(new Integer('commit_log_id'));
        $create_commit_file_status->addConstraint(new ForeignKey('fk_commit_log', 'commit_log_id', 'commit_log', 'commit_log_id'));
        $create_commit_file_status->addColumn(new Char('status', 1));
        $create_commit_file_status->addColumn(new Varchar('name', 512));
        $this->addSql($create_commit_file_status->getSqlString($this->adapter->getPlatform()));
    }

    public function down(MetadataInterface $schema)
    {
        $drop_commit_file_status = new DropTable('commit_file_status');
        $this->addSql($drop_commit_file_status->getSqlString($this->adapter->getPlatform()));

        $drop_commit_log = new DropTable('commit_log');
        $this->addSql($drop_commit_log->getSqlString($this->adapter->getPlatform()));
    }
}
