<?php

namespace Fungku\HubSpot\Http;

use Fungku\HubSpot\Contracts\HttpClient;

class Client implements HttpClient
{
    /**
     * @var \Client
     */
    protected $client;

    const USER_AGENT = 'Fungku_HubSpot_PHP/0.9 (https://github.com/fungku/hubspot-php)';
    /**
     * Make it, baby.
     *
     * @param \Client $client
     */
    public function __construct(HttpClient $client = null)
    {
        $this->client = $client;
    }

    /**
     * Submit the request and build the response object.
     *
     * @param string $method
     * @param string $url
     * @param array  $options
     * @return \CurlResponse
     */
    private function makeRequest($method, $url, $options)
    {
        if(!empty($options['query'])){
            $queryString = '';
            foreach ($options['query'] as $k => $item) {
                $queryString .= "&{$k}={$item}";
            }
            $url = $url.$queryString;
        }

        if(!empty($options['body'])){
            $urlencode = '';
            foreach ($options['body'] as $k => $item) {
                if(empty($urlencode))
                    $urlencode .= "{$k}={$item}";
                else    
                    $urlencode .= "&{$k}={$item}";
            }
        }

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        
        switch($method)
        {
            case 'GET':            
            break;

            case 'POST':
                curl_setopt($ch, CURLOPT_POST, true);
                if(!empty($options['json'])){
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($options['json']));
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                }

                if(!empty($options['body'])){
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($urlencode));
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
                }

            break;

            case 'PUT':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
                if(!empty($options['json'])){
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($options['json']));
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                }

                if(!empty($options['body'])){
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($urlencode));
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
                }
            break;

            case 'DELETE':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
                if(!empty($options['json'])){
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($options['json']));
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                }

                if(!empty($options['body'])){
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($urlencode));
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
                }
            break;
            default:
        }
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_USERAGENT, self::USER_AGENT);          
        curl_setopt($ch, CURLOPT_ENCODING , "gzip");           
        $output = curl_exec($ch);
        $errno = curl_errno($ch);
        $error = curl_error($ch);
        curl_close($ch);
        if ( $errno > 0 )
            throw new Exception('cURL error: ' . $error);
        else
            return json_decode($output, true);
    }

    /**
     * @param  string $url
     * @param  array  $options
     * @return \Fungku\HubSpot\Http\Response
     */
    public function get($url, $options = array())
    {
        
        return $this->makeRequest('GET', $url, $options);
    }

    /**
     * @param  string $url
     * @param  array  $options
     * @return \Fungku\HubSpot\Http\Response
     */
    public function post($url, $options = array())
    {
        return $this->makeRequest('POST', $url, $options);
    }

    /**
     * @param  string $url
     * @param  array  $options
     * @return \Fungku\HubSpot\Http\Response
     */
    public function put($url, $options = array())
    {
        return $this->makeRequest('PUT', $url, $options);
    }

    /**
     * @param  string $url
     * @param  array  $options
     * @return \Fungku\HubSpot\Http\Response
     */
    public function delete($url, $options = array())
    {
        return $this->makeRequest('DELETE', $url, $options);
    }
}
