<?php

namespace Drupal\masstimes;

use \Drupal\Core\Utility\Error;
use GuzzleHttp\ClientInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


/**
 * Class massTimesService.
 */
class massTimesService {

   
    /**
     * @var ClientInterface $httpClient
     */

    protected $httpClient;

    /**
     * Class constructor.
     */
    public function __construct(ClientInterface $http_client) {
        $this->httpClient = $http_client;
    }


    /**
     * {@inheritDoc}
     */
    public static function create(ContainerInterface $container) {
        return new static(
            $container->get('http_client')
        );
    }

    /**
     * Function that is provided user coords from JS hooks and Controller.php. Appends to url for API request
     * 
     * @param $latitude
     * @param $longitude
     * @return array
     */
    public function fetchData($latitude, $longitude) {
        
        
        $url = 'https://apiv4.updateparishdata.org/Churchs/?lat='.trim($latitude).'&long='.trim($longitude).'&pg=1';
        
        $json_data = '{ "church_address_city_name" : "Puchenstuben",
            "church_address_country_territory_name" : "Austria",
            "church_address_county" : null,
            "church_address_postal_code" : "3214",
            "church_address_providence_name" : "Lower Austria",
            "church_address_street_address" : "5 Puchenstuben Rd.",
            "church_type_name" : "Parish",
            "church_worship_times" : [ { "comment" : "",
                  "day_of_week" : "99",
                  "id" : "935441",
                  "is_perpetual" : false,
                  "language" : "English ",
                  "service_typename" : "Devotions",
                  "time_end" : "1/1/1900 12:00:00 AM",
                  "time_start" : "1/1/1900 12:00:00 AM"
                },
                { "comment" : "",
                  "day_of_week" : "0",
                  "id" : "935442",
                  "is_perpetual" : false,
                  "language" : "German ",
                  "service_typename" : "Weekend",
                  "time_end" : null,
                  "time_start" : "1/1/1900 10:00:00 AM"
                },
                { "comment" : "Nov - Dec",
                  "day_of_week" : "6",
                  "id" : "1250169",
                  "is_perpetual" : false,
                  "language" : "German ",
                  "service_typename" : "Weekend",
                  "time_end" : "1/1/1900 12:00:00 AM",
                  "time_start" : "1/1/1900 5:00:00 PM"
                }
              ],
            "comments" : "",
            "diocese_name" : "Sankt Pollten",
            "diocese_type_name" : null,
            "directions" : "",
            "distance" : "21.413402072542",
            "email" : "bo.stpoelten@kirche.at",
            "id" : "5634",
            "language_name" : "German ",
            "last_update" : "3/21/2012 3:00:30 AM",
            "lat_long_source" : null,
            "latitude" : "47.9299467",
            "longitude" : "15.2618797",
            "military_time" : true,
            "name" : "St.Ann",
            "pastors_name" : " ",
            "phone_number" : "0748248201",
            "rite_type_name" : "Roman-Latin",
            "url" : "www.kirche.at/stpoelten/pfarren/pfarrinfo.php?links=Puchenstuben",
            "wheel_chair_access" : true
          }';

          /*$data = json_decode($json_data, TRUE);

          return [
            '#theme' => 'churchinfo',
            '#church_data' => $data,
        
        ];*/
        try {
            
            $response = $this->httpClient->request('GET', $url );
    
             $data = json_decode($response->getBody()->getContents(), TRUE);
             $data1 = $data[0];


            return [
                '#theme' => 'churchinfo',
                '#church_data' => $data1,
            
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