<?php

namespace Drupal\hello_world;

use StringTranslationTrait;
use \Drupal\Core\Utility\Error;
use GuzzleHttp\ClientInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class HelloWorldTest {

   


    protected $httpClient;


    public function __construct(ClientInterface $http_client) {
        $this->httpClient = $http_client;
    }

    public static function create(ContainerInterface $container) {
        return new static(
            $container->get('http_client')
        );
    }
    public function fetchData() {
        $api_key = '74e45c40-7f11-11e1-b0c4-0800200c9a66';
        $latitude = '42.733620';
        $longitude = '-84.553932';
        
        $url = 'https://apiv4.updateparishdata.org/Churchs/?lat='.trim($latitude).'&long='.trim($longitude).'&pg=1';
        
        try {
            
            $response = $this->httpClient->request('GET', $url );
            $data = json_decode($response->getBody()->getContents(), TRUE);
           
            $render = [
                '#type' => 'markup',
                '#markup' => '<p id="location-info"></p>',
                '#attached' => [
                    'library' => [
                        'hello_world/hello_world_geolocation',
                    ],
                ],
            ];
            return [
                $render
                /*'#type' => 'table',
                '#rows' => $data[0]['church_worship_times'],            
                '#title' => $this->t('API Data'),*/
            ];
  

        } catch (\Exception $e) {
            $logger = \Drupal::logger('hello_world');
            Error::logException($logger, $e);
            return [
                '#markup' => $this->t('Failed to fetch data.'),
            ];
        }
    }
}