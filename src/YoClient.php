<?php
namespace Websoftwares;
/**
* YoClient connects and executes methods on the API endpoint
*
* @package Websoftwares
* @license http://opensource.org/licenses/MIT
* @author Boris <boris@websoftwar.es>
*/
class YoClient implements YoClientInterface
{

    /**
     * Yo API endpoint
     */
    const ENDPOINT = "http://api.justyo.co/";

    /**
     * @var array
     */
    protected $curlOptions = [
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_FAILONERROR => 1,
        CURLOPT_POST => 0,
        CURLOPT_TIMEOUT => 10,
        CURLOPT_URL => '',
        CURLOPT_USERAGENT => 'Websoftwares Yo PHP client'
    ];

    /**
     * @var array
     */
    protected $params = [];

    /**
     * __construct
     * @param string $apiToken
     */
    public function __construct($apiToken = null)
    {
        if (! $apiToken) {
            throw new YoException('An api token must be provided');
        }
        // Set API key
        $this->setParams('api_token', $apiToken);
    }

    /**
     * Getter for curlOptions
     *
     * @return array
     */
    protected function getCurlOptions()
    {
        return $this->curlOptions;
    }

    /**
     * setCurlOption
     *
     * @param  string $option
     * @param  string $value
     * @return self
     */
    public function setCurlOption($option = null, $value = null)
    {
        $this->curlOptions[$option] = $value;

        return $this;
    }

    /**
     * buildQueryString
     *
     * @param $params array
     * @return string
     */
    protected function buildQueryString(array $params = [])
    {
        return http_build_query($params, null, '&');
    }

    /**
     * getParams
     *
     * @return array
     */
    protected function getParams()
    {
        return $this->params;
    }

    /**
     * setParams
     *
     * @param $key the param key
     * @param $value the param value
     * @return self
     */
    public function setParams($key = null, $value = null)
    {
        $this->params[$key] = $value;

        return $this;
    }

    /**
     * post    post method to perform on the api endpoint
     * @param  string $method
     * @return self
     */
    public function post($method)
    {
        $this->setCurlOption(CURLOPT_POST, 1)
             ->setCurlOption(CURLOPT_POSTFIELDS, $this->params)
             ->setCurlOption(CURLOPT_URL, self::ENDPOINT
                . "/"
                . $method
                . "/");

        return $this;
    }

    /**
     * get     get method to perform on the api endpoint
     * @param  string $method
     * @return self
     */
    public function get($method)
    {
        $this->setCurlOption(CURLOPT_URL,self::ENDPOINT
            . "/"
            . $method
            . "/?"
            . $this->buildQueryString($this->params));

        return $this;
    }

    /**
     * execute
     *
     * @return mixed
     */
    public function execute()
    {
        // Get curl options
        $curlOptions = $this->getCurlOptions();

        // Init curl
        $curl = curl_init();

        // Set options
        curl_setopt_array($curl, $curlOptions);

        // Execute and assing response to $response
        if (!$response = curl_exec($curl)) {
            throw new YoException(curl_error($curl), curl_errno($curl));
        }

        // Close request to clear up some resources
        curl_close($curl);

        // Decode json response
        $response = json_decode($response);

        // Valid response
        if ($response->result === 0 || $response->result) {
            return $response;
        //Invalid responses
        } elseif ($response->code && $response->error) {
            throw new YoException($response->code,$response->error);
        } else {
            throw new YoException("Error processing request");
        }
    }
}
