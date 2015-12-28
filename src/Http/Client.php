<?php

namespace Fungku\HubSpot\Http;

use Fungku\HubSpot\Contracts\HttpClient;
use \Httpful\Request as HttpfulClient;

class Client implements HttpClient
{
    /**
     * @var \Client
     */
    protected $client;

    /**
     * Make it, baby.
     *
     * @param \Client $client
     */
    public function __construct($client = null)
    {
        //$this->client = $client ?: HttpfulClient;
    }

    /**
     * Submit the request and build the response object.
     *
     * @param string $method
     * @param string $url
     * @param array  $options
     * @return \HttpfulClient\Response
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
        
        if(!empty($options['json'])){
            $response = HttpfulClient::$method($url)
                            ->body(json_encode($options['json']))
                            ->sendsJson()
                            ->send(); 
        }
        elseif(!empty($options['body'])){
            $response = HttpfulClient::$method($url)
                            ->body(json_encode($options['body']))
                            ->sendsForm()
                            ->send();
        } 
        else
        {
            $response = HttpfulClient::$method($url)
                            ->send();
        }            
        
        return $response->body;
    }

    /**
     * @param  string $url
     * @param  array  $options
     * @return \Fungku\HubSpot\Http\Response
     */
    public function get($url, $options = array())
    {
        return $this->makeRequest('get', $url, $options);
    }

    /**
     * @param  string $url
     * @param  array  $options
     * @return \Fungku\HubSpot\Http\Response
     */
    public function post($url, $options = array())
    {
        return $this->makeRequest('post', $url, $options);
    }

    /**
     * @param  string $url
     * @param  array  $options
     * @return \Fungku\HubSpot\Http\Response
     */
    public function put($url, $options = array())
    {
        return $this->makeRequest('put', $url, $options);
    }

    /**
     * @param  string $url
     * @param  array  $options
     * @return \Fungku\HubSpot\Http\Response
     */
    public function delete($url, $options = array())
    {
        return $this->makeRequest('delete', $url, $options);
    }
}
