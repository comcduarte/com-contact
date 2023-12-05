<?php
namespace Contact\Controller\Factory;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;
use Contact\Controller\ConfigController;

class ConfigControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $controller = new ConfigController();
        $adapter = $container->get('contact-model-adapter');
        $controller->setDbAdapter($adapter);
        return $controller;
    }
}