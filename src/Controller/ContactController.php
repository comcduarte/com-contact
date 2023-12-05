<?php
namespace Contact\Controller;

use Components\Controller\AbstractBaseController;
use Contact\Entity\ContactEntity;
use Contact\Form\ContactForm;
use Contact\Model\Contact;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\Sql\Select;
use Laminas\Db\Sql\Sql;
use Laminas\View\Model\ViewModel;

class ContactController extends AbstractBaseController
{
    public function dashboardAction()
    {
        $view = new ViewModel();
        
        /**
         * Contacts
         */
        $contact = new Contact($this->adapter);
        $sql = new Sql($this->adapter);
        $select = new Select();
        $select->from($contact->getTableName());
        $select->columns([
            'UUID' => 'UUID',
            'First Name' => 'FNAME',
            'Last Name' => 'LNAME',
        ]);
        $select->where(['STATUS' => $contact::ACTIVE_STATUS]);
        $select->order('LNAME ASC');
        
        $statement = $sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();
        $resultSet = new ResultSet($results);
        $resultSet->initialize($results);
        $data = $resultSet->toArray();
        
        $header = [];
        if (!empty($data)) {
            $header = array_keys($data[0]);
        }
        
        $params = [
            [
                'route' => 'contact/default',
                'action' => 'update',
                'key' => 'UUID',
                'label' => 'Update',
            ],
            [
                'route' => 'contact/default',
                'action' => 'delete',
                'key' => 'UUID',
                'label' => 'Delete',
            ],
        ];
        
        $contact_list = [
            'data' => $data,
            'header' => $header,
            'primary_key' => $this->model->getPrimaryKey(),
            'params' => $params,
            'search' => true,
            'title' => 'Contact List',
        ];
        $view->setVariable('contact_list', $contact_list);
        return $view;
    }

    public function updateAction()
    {
        $primary_key = $this->params()->fromRoute(strtolower($this->model->getPrimaryKey()),0);
        if (!$primary_key) {
            $this->flashmessenger()->addErrorMessage("Unable to retrieve record. Value not passed.");
            
            $url = $this->getRequest()->getHeader('Referer')->getUri();
            return $this->redirect()->toUrl($url);
        }
        
        $view = new ViewModel();
        $view->setTemplate('contact/contact/update');
        
        /**
         * CONTACT
         */
        $contact = new ContactEntity($this->adapter);
        $contact->read(['UUID' => $primary_key]);
        
        $contact_form = new ContactForm();
        $contact_form->init();
        $contact_form->bind($contact->CONTACT);
        
        $contact_info = [
            'form' => $contact_form,
            'title' => 'Contact Information',
            'primary_key' => $contact->CONTACT->getPrimaryKey(),
        ];
        $view->setVariable('contact', $contact_info);
        
        /**
         * ADDRESSES
         */
        $data = [];
        foreach ($contact->CONTACT_ADDR as $addr) {
            $data[] = $addr->toArray(['NAME','NUM','STREET']);
        }
        if (!empty($data)) {$header = array_keys($data[0]);}
        
        $contact_addresses = [
            'title' => 'Addresses',
            'data' => $data,
            'primary_key' => 'UUID',
            'search' => false,
            'header' => $header,
            'params' => [
            ],
        ];
        $view->setVariable('contact_addr', $contact_addresses);
        
        /**
         * PHONE
         */
        $data = [];
        foreach ($contact->CONTACT_PHONE as $phone) {
            $data[] = $phone->toArray(['NAME','TYPE','PHONE']);
        }
        if (!empty($data)) {$header = array_keys($data[0]);}
        
        $contact_phone = [
            'title' => 'Phone',
            'data' => $data,
            'primary_key' => 'UUID',
            'search' => false,
            'header' => $header,
            'params' => [
            ],
        ];
        $view->setVariable('contact_phone', $contact_phone);
        
        /**
         * EMAIL
         */
        $data = [];
        foreach ($contact->CONTACT_EMAIL as $email) {
            $data[] = $email->toArray(['NAME','EMAIL']);
        }
        if (!empty($data)) {$header = array_keys($data[0]);}
        
        
        $contact_email = [
            'title' => 'Email Addresses',
            'data' => $data,
            'primary_key' => 'UUID',
            'search' => false,
            'header' => $header,
            'params' => [
            ],
        ];
        $view->setVariable('contact_email', $contact_email);
        
        return $view;
    }
}