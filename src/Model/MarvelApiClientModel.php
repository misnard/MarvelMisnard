<?php

namespace Marvel\Model;

/**
 * Main class to communicate with marvel api
 *
 * Class MarvelApiClientModel
 * @package Marvel\Model
 */
class MarvelApiClientModel
{
    /**
     * Marvel Public key
     */
    const MARVEL_PUBLIC_KEY = '';
    /**
     * Marvel Private key
     */
    const MARVEL_PRIVATE_KEY = '';

    /**
     * Marvel base url api
     */
    const MARVEL_API_BASE_URL = 'https://gateway.marvel.com:443/v1/public/';

    /**
     * Contain current curl instance
     *
     * @var resource
     */
    private $curlInstance;

    /**
     * Open curl instance on Class construct
     *
     * Marvel_ApiClient_Model constructor.
     */
    public function __construct()
    {
        $this->curlInstance = curl_init();
    }

    /**
     * Close current curl instance on Class destruct
     */
    public function __destruct()
    {
        curl_close($this->curlInstance);
    }

    /**
     * Generate hash for api call security
     *
     * @return string
     */
    public static function getCurrentHash()
    {
        return md5(time() . self::MARVEL_PRIVATE_KEY . self::MARVEL_PUBLIC_KEY);
    }

    /**
     * Get type and parameters to build final url with parameters, api key, timestamp, hash
     *
     * @param string $type
     * @param array $urlParameters
     * @return string
     */
    public function constructUrl($type, $urlParameters = array())
    {
        $parameters = '';
        if ($urlParameters) {
            foreach ($urlParameters as $parameterName => $parameterValue) {
                $parameters .= $parameters ? '&' : '?';
                $parameters .= $parameterName . '=' . $parameterValue;
            }
        }
        return self::MARVEL_API_BASE_URL . $type . $parameters . '&apikey=' . self::MARVEL_PUBLIC_KEY . '&hash='
            . $this->getCurrentHash() . '&ts=' . time();
    }

    /**
     * Method who return data fetched by url in json
     *
     * @param string $callUrl
     * @return object|array
     */
    public function apiConnector($callUrl)
    {
        $this->catchApiBeforeErrors($callUrl);
        curl_setopt_array($this->curlInstance, array(
            CURLOPT_URL => $callUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache"
            ),
        ));

        $apiResult =  json_decode(curl_exec($this->curlInstance));
        $this->catchApiAfterErrors($apiResult);

        return $apiResult;
    }

    /**
     * Return characters collection
     *
     * @return string
     */
    public function getCharactersCollection()
    {
        try {
            $apiResult = $this->apiConnector($this->constructUrl('characters',
                array('limit' => '20', 'offset' => '100')));
        } catch (\Exception $e) {
            return 'Error : ' . $e;
        }

        return $apiResult->data->results;
    }

    /**
     * Catch Errors on url construction error
     *
     * @param $callUrl
     * @throws \Exception
     */
    public function catchApiBeforeErrors($callUrl) {
        if (!filter_var($callUrl, FILTER_VALIDATE_URL)) {
            throw new \Exception('Invalid Url : Bad format');
        }
        if (!strpos($callUrl, 'apikey=')) {
            throw new \Exception('Invalid Url : Missed Api key');
        }
        if (!strpos($callUrl, 'ts=')) {
            throw new \Exception('Invalid Url : Missed TimeStamp');
        }
        if (!strpos($callUrl, 'hash=')) {
            throw new \Exception('Invalid Url : Missed Hash');
        }
    }

    /**
     * Check api response code to catch error and create new exception
     *
     * @param object $apiResult
     * @throws \Exception
     */
    public function catchApiAfterErrors($apiResult)
    {
        if ($apiResult->code != '200' || $apiResult->status != 'Ok') {
            throw new \Exception('Error on api response code : ' . $apiResult->code);
        }
        if ($error = curl_error($this->curlInstance)) {
            throw new \Exception('Error on api connexion : ' . $error);
        }
    }
}
