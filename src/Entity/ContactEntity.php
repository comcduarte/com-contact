<?php
namespace Contact\Entity;

use Contact\Model\Contact;
use Contact\Model\ContactAddress;
use Contact\Model\ContactEmail;
use Contact\Model\ContactPhone;
use Laminas\Db\Adapter\Adapter;
use Laminas\Db\Adapter\AdapterAwareTrait;
use Laminas\Db\Adapter\Exception\InvalidQueryException;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\Sql\Select;
use Laminas\Db\Sql\Sql;
use Laminas\Db\Sql\Where;

class ContactEntity
{
    use AdapterAwareTrait;
    
    /**
     * 
     * @var Contact
     */
    public $CONTACT;
    
    /**
     * 
     * @var array|ContactAddress
     */
    public $CONTACT_ADDR = [];
    
    /**
     * 
     * @var array|ContactPhone
     */
    public $CONTACT_PHONE = [];
    
    /**
     * 
     * @var array|ContactEmail
     */
    public $CONTACT_EMAIL = [];
    
    /**
     * 
     * @param Adapter $adapter
     * @return \Contact\Entity\ContactEntity
     */
    public function __construct($adapter = NULL)
    {
        $this->setDbAdapter($adapter);
        return $this;
    }
    
    public function read(array $criteria)
    {
        /**
         * CONTACT
         */
        $this->CONTACT = new Contact($this->adapter);
        if (! $this->CONTACT->read($criteria)) {
            throw new InvalidQueryException(); 
        }
        
        $this->CONTACT_EMAIL = $this->fetch(new ContactEmail($this->adapter));
        $this->CONTACT_PHONE = $this->fetch(new ContactPhone($this->adapter));
        $this->CONTACT_ADDR = $this->fetch(new ContactAddress($this->adapter));
    }
    
    private function fetch($object)
    {
        $arrayObjects = [];
        
        $where = new Where();
        $where->equalTo('CONTACT_UUID', $this->CONTACT->UUID);
        
        $sql = new Sql($this->adapter);
        
        $select = new Select();
        $select->columns([$object->getPrimaryKey()]);
        $select->from($object->getTableName());
        $select->where($where);
        
        $statement = $sql->prepareStatementForSqlObject($select);
        $resultSet = new ResultSet();
        
        try {
            $results = $statement->execute();
            $resultSet->initialize($results);
        } catch (InvalidQueryException $e) {
            return FALSE;
        }
        
        foreach ($resultSet->toArray() as $prikey) {
            $object->read([$object->getPrimaryKey() => $prikey]);
            $arrayObjects[] = $object;
        }
        
        return $arrayObjects;
    }
}