<?php
namespace Contact\Controller;

use Components\Controller\AbstractConfigController;
use Laminas\Db\Adapter\Exception\InvalidQueryException;
use Laminas\Db\Sql\Sql;
use Laminas\Db\Sql\Ddl\CreateTable;
use Laminas\Db\Sql\Ddl\DropTable;
use Laminas\Db\Sql\Ddl\Column\Varchar;
use Laminas\Db\Sql\Ddl\Constraint\PrimaryKey;
use Laminas\Db\Sql\Ddl\Constraint\ForeignKey;

class ConfigController extends AbstractConfigController
{
    public function clearDatabase()
    {
        $sql = new Sql($this->adapter);
        $ddl = [];
        
        $ddl[] = new DropTable('contact_addr');
        $ddl[] = new DropTable('contact_phone');
        $ddl[] = new DropTable('contact_email');
        $ddl[] = new DropTable('contact');
        
        foreach ($ddl as $obj) {
            try {
                $this->adapter->query($sql->buildSqlString($obj), $this->adapter::QUERY_MODE_EXECUTE);
            } catch (InvalidQueryException $e) {
                $this->flashMessenger()->addErrorMessage($e->getMessage());
            }
        }
        
        $this->clearSettings('CONTACT');
    }
    
    public function createDatabase()
    {
        /******************************
         * CONTACT
         ******************************/
        $ddl = new CreateTable('contact');
        $ddl = $this->addStandardFields($ddl);
        
        $ddl->addColumn(new Varchar('TITLE', 255, TRUE));
        $ddl->addColumn(new Varchar('FNAME', 255, TRUE));
        $ddl->addColumn(new Varchar('MNAME', 255, TRUE));
        $ddl->addColumn(new Varchar('LNAME', 255, TRUE));
        $ddl->addColumn(new Varchar('SUFFIX', 5, TRUE));
        $ddl->addColumn(new Varchar('FILEAS', 255, TRUE));
        
        $ddl->addConstraint(new PrimaryKey('UUID'));
        
        $this->processDdl($ddl);
        unset($ddl);
        
        /******************************
         * ADDRESSES
         ******************************/
        $ddl = new CreateTable('contact_addr');
        $ddl = $this->addStandardFields($ddl);
        
        $ddl->addColumn(new Varchar('CONTACT_UUID', 36, TRUE));
        $ddl->addColumn(new Varchar('NAME', 255, TRUE));
        $ddl->addColumn(new Varchar('NUM', 255, TRUE));
        $ddl->addColumn(new Varchar('STREET', 255, TRUE));
        $ddl->addColumn(new Varchar('CITY', 255, TRUE));
        $ddl->addColumn(new Varchar('STATE', 255, TRUE));
        $ddl->addColumn(new Varchar('ZIP', 255, TRUE));
        
        $ddl->addConstraint(new PrimaryKey('UUID'));
        $ddl->addConstraint(new ForeignKey('CONTACT_ADDR', 'CONTACT_UUID', 'contact', 'UUID', 'CASCADE', 'NO ACTION'));
        
        $this->processDdl($ddl);
        unset($ddl);
        
        /******************************
         * PHONE
         ******************************/
        $ddl = new CreateTable('contact_phone');
        $ddl = $this->addStandardFields($ddl);
        
        $ddl->addColumn(new Varchar('CONTACT_UUID', 36, TRUE));
        $ddl->addColumn(new Varchar('NAME', 255, TRUE));
        $ddl->addColumn(new Varchar('TYPE', 255, TRUE));
        $ddl->addColumn(new Varchar('PHONE', 255, TRUE));
        
        $ddl->addConstraint(new PrimaryKey('UUID'));
        $ddl->addConstraint(new ForeignKey('CONTACT_PHONE', 'CONTACT_UUID', 'contact', 'UUID', 'CASCADE', 'NO ACTION'));
        
        $this->processDdl($ddl);
        unset($ddl);
        
        /******************************
         * EMAIL
         ******************************/
        $ddl = new CreateTable('contact_email');
        $ddl = $this->addStandardFields($ddl);
        
        $ddl->addColumn(new Varchar('CONTACT_UUID', 36, TRUE));
        $ddl->addColumn(new Varchar('NAME', 255, TRUE));
        $ddl->addColumn(new Varchar('EMAIL', 255, TRUE));
        
        $ddl->addConstraint(new PrimaryKey('UUID'));
        $ddl->addConstraint(new ForeignKey('CONTACT_EMAIL', 'CONTACT_UUID', 'contact', 'UUID', 'CASCADE', 'NO ACTION'));
        
        $this->processDdl($ddl);
        unset($ddl);
    }
}