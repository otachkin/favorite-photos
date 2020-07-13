<?php
namespace App\Services;

use GuzzleHttp\Client;

class Photos
{
    protected $client;
    protected $query_params = [];

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Main method to get photo data
     *
     * @return array|mixed
     */
    public function get()
    {
        return $this->endpointRequest('/photos');
    }

    public function limit($start, $limit){
        $this->query_params['_start'] = $start;
        $this->query_params['_limit'] = $limit;

        return $this;
    }

    /**
     * Send request
     *
     * @param $endpoint
     * @return array|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function endpointRequest($endpoint)
    {
        $url = $this->createUrlWithParams($endpoint);

        try {
            $response = $this->client->request('GET', $url);
        } catch (\Exception $e) {
            return [];
        }

        return $this->responseHandler($response->getBody()->getContents());
    }

    /**
     * Handle response
     *
     * @param $response
     * @return array|mixed
     */
    public function responseHandler($response)
    {
        if ($response) {
            return json_decode($response);
        }

        return [];
    }

    /**
     * Helper to make endpoint with parameters
     *
     * @param $endpoint
     * @return string
     */
    private function createUrlWithParams($endpoint){
        $query_string = $this->query_params ? '?'.http_build_query($this->query_params) : '';
        return $endpoint.$query_string;
    }
}
