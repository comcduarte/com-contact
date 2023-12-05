<?php
namespace Contact\Form;

use Components\Form\AbstractBaseForm;
use Laminas\Db\Adapter\AdapterAwareTrait;
use Laminas\Form\Element\Text;
use Laminas\Form\Element\Select;

class ContactForm extends AbstractBaseForm
{
    use AdapterAwareTrait;
    
    public function init()
    {
        parent::init();
        
        $this->add([
            'name' => 'TITLE',
            'type' => Select::class,
            'attributes' => [
                'class' => 'form-control',
                'id' => 'TITLE',
                'placeholder' => '',
            ],
            'options' => [
                'label' => 'Title',
                'value_options' => [
                    'Mr.',
                    'Mrs.',
                    'Ms.',
                    'Mx.',
                ],
            ],
        ],['priority' => 100]);
        
        $this->add([
            'name' => 'FNAME',
            'type' => Text::class,
            'attributes' => [
                'class' => 'form-control',
                'id' => 'FNAME',
                'required' => 'true',
                'placeholder' => '',
            ],
            'options' => [
                'label' => 'First Name',
            ],
        ],['priority' => 100]);
        
        $this->add([
            'name' => 'MNAME',
            'type' => Text::class,
            'attributes' => [
                'class' => 'form-control',
                'id' => 'MNAME',
                'placeholder' => '',
            ],
            'options' => [
                'label' => 'Middle Name',
            ],
        ],['priority' => 100]);
        
        $this->add([
            'name' => 'LNAME',
            'type' => Text::class,
            'attributes' => [
                'class' => 'form-control',
                'id' => 'LNAME',
                'required' => 'true',
                'placeholder' => '',
            ],
            'options' => [
                'label' => 'Last Name',
            ],
        ],['priority' => 100]);
        
        $this->add([
            'name' => 'SUFFIX',
            'type' => Select::class,
            'attributes' => [
                'class' => 'form-control',
                'id' => 'SUFFIX',
                'placeholder' => '',
            ],
            'options' => [
                'label' => 'Suffix',
                'value_options' => [
                    NULL,
                    'Jr.',
                    'Sr.',
                    'II',
                    'III',
                    'IV'
                ],
            ],
        ],['priority' => 100]);
        
        $this->add([
            'name' => 'FILEAS',
            'type' => Text::class,
            'attributes' => [
                'class' => 'form-control',
                'id' => 'FILEAS',
                'placeholder' => '',
            ],
            'options' => [
                'label' => 'File As...',
            ],
        ],['priority' => 100]);
    }
}