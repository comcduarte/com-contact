<?php
namespace Contact\Model;

use Components\Model\AbstractBaseModel;

class ContactAddress extends AbstractBaseModel
{
    public $CONTACT_UUID;
    public $NAME;
    public $NUM;
    public $STREET;
    public $CITY;
    public $STATE;
    public $ZIP;
    
    public function __construct($adapter = NULL)
    {
        parent::__construct($adapter);
        $this->setTableName('contact_addr');
    }
    
    public function toArray($attributes = null)
    {
        if ($attributes == null) {
            $attributes = $this->public_attributes;
        }
        
        $array = [];
        foreach ($attributes as $value) {
            $array[$value] = $this->$value;
        }
        return $array;
    }
}