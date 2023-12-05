<?php
namespace Contact\Form\Factory;

use Contact\Form\ContactForm;
use Psr\Container\ContainerInterface;

class ContactFormFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $form = new ContactForm();
        return $form;
    }
}