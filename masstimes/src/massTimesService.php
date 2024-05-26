<?php

namespace Drupal\masstimes;

use \Drupal\Core\Utility\Error;
use GuzzleHttp\ClientInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


class massTimesService {

   


    protected $httpClient;


    public function __construct(ClientInterface $http_client) {
        $this->httpClient = $http_client;
    }

    public static function create(ContainerInterface $container) {
        return new static(
            $container->get('http_client')
        );
    }
    public function fetchData($latitude, $longitude) {
        
        
        $url = 'https://apiv4.updateparishdata.org/Churchs/?lat='.trim($latitude).'&long='.trim($longitude).'&pg=1';
        
        try {
            
            $response = $this->httpClient->request('GET', $url );
    
             $data = json_decode($response->getBody()->getContents(), TRUE);
            return [
            '#type' => 'table',
            '#rows' => $data[0]['church_worship_times'],            
            '#title' => ('API Data'),
        ];
  

        } catch (\Exception $e) {
            $logger = \Drupal::logger('whoops');
            Error::logException($logger, $e);
            return [
                '#markup' => ('Failed to fetch data.'),
            ];
        }
    }
}