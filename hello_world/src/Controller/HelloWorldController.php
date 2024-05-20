<?php

namespace Drupal\hello_world\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\hello_world\HelloWorldTest;
use Symfony\Component\DependencyInjection\ContainerInterface;

class HelloWorldController extends ControllerBase {
    
    
    protected $service;

    public function __construct(HelloWorldTest $service) {
        $this->service = $service;
    }
   
    public static function create(ContainerInterface $container) {
        return new static($container->get('hello_world.test')
        );
    }

    public function helloWorld() {
        return [
            //$this->service->fetchData(),
        ];
    }
}