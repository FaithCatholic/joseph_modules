<?php

namespace Drupal\hello_world\Plugin\Block;


use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\hello_world\HelloWorldTest;



/**
 * @Block (
 * id = "hello_world_block",
 * admin_label = @Translation("Hello world block"),
 * )
 */

class HelloWorldBlock extends BlockBase implements ContainerFactoryPluginInterface {
    
    protected $service;
    
    public function __construct(array $configuration, $plugin_id, $plugin_definition, HelloWorldTest $service) {
        parent::__construct($configuration, $plugin_id, $plugin_definition);
        $this->service = $service;
    }

    public static function create(ContainerInterface $container, array $configuration,
    $plugin_id, $plugin_definition) { 
        return new static(
            $configuration,
            $plugin_id,
            $plugin_definition,
            $container->get('hello_world.test')
        );
    }

    public function build() {
        return [
            $this->service->fetchData(),
        ];
    }

}