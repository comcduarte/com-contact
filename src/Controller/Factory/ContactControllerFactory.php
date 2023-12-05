<?php
namespace Contact\Controller\Factory;

use Contact\Controller\ContactController;
use Contact\Form\ContactForm;
use Contact\Model\Contact;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class ContactControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $controller = new ContactController();
        
        $adapter = $container->get('contact-model-adapter');
        
        $model = new Contact($adapter);
        $form = $container->get('FormElementManager')->get(ContactForm::class);
        
        $controller->setModel($model);
        $controller->setForm($form);
        $controller->setDbAdapter($adapter);
        return $controller;
    }
}