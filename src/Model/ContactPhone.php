<?php
namespace Contact\Model;

use Components\Model\AbstractBaseModel;

class ContactPhone extends AbstractBaseModel
{
    public $CONTACT_UUID;
    public $NAME;
    public $TYPE;
    public $PHONE;
    
    public function __construct($adapter = NULL)
    {
        parent::__construct($adapter);
        $this->setTableName('contact_phone');
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