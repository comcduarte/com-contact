<?php
namespace Contact\Model;

use Components\Model\AbstractBaseModel;

class Contact extends AbstractBaseModel
{
    public $TITLE;
    public $FNAME;
    public $MNAME;
    public $LNAME;
    public $SUFFIX;
    public $FILEAS;
    
    public function __construct($adapter = NULL)
    {
        parent::__construct($adapter);
        $this->setTableName('contact');
    }
}