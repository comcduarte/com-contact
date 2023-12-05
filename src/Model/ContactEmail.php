<?php
namespace Contact\Model;

use Components\Model\AbstractBaseModel;

class ContactEmail extends AbstractBaseModel
{
    public $CONTACT_UUID;
    public $NAME;
    public $EMAIL;
    
    public function __construct($adapter = NULL)
    {
        parent::__construct($adapter);
        $this->setTableName('contact_email');
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