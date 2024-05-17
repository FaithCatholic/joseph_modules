<?

namespace Drupal\hello_world\Controller;

use \Drupal\Core\Utility\Error;
use Drupal\Core\Controller\ControllerBase;
use GuzzleHttp\ClientInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class HelloWorldController extends ControllerBase {
    
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
        $api_key = '4e45c40-7f11-11e1-b0c4-0800200c9a66';
        $url = 'https://apiv4.updateparishdata.org/' . urlencode ($api_key);
        
        try {
            $response = $this->httpClient->request('GET', $url );
            $data = json_decode($response->getBody(), TRUE);

            return [
                '#theme' => 'item_list',
                '#items' => $data,
                '#title' => $this->t('API Data'),
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