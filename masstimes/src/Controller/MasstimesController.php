<?php

namespace Drupal\masstimes\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\masstimes\massTimesService;
use Symfony\Component\DependencyInjection\ContainerInterface;

class massTimesController extends ControllerBase {
    
    
    protected $service;

    public function __construct(massTimesService $service) {
        $this->service = $service;
    }
   
    public static function create(ContainerInterface $container) {
        return new static($container->get('masstimes.service')
        );
    }

    public function output() {
        return [
            $this->service->fetchData(),
        ];
    }
}