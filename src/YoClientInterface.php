<?php
namespace Websoftwares;
/**
* YoClientInterface defines the methods for making a
*                   connection and executing methods on the API endpoint.
*
* @package Websoftwares
* @license http://opensource.org/licenses/MIT
* @author Boris <boris@websoftwar.es>
*/
interface YoClientInterface
{
    /**
     * setParams
     *
     * @param $key the param key
     * @param $value the param value
     * @return self
     */
    public function setParams($key = null, $value = null);
    /**
     * setCurlOption
     *
     * @param  string $option
     * @param  string $value
     * @return self
     */
    public function setCurlOption($option = null, $value = null);
    /**
     * post    post method to perform on the api endpoint
     * @param  string $method
     * @return self
     */
    public function post($method);
    /**
     * get     get method to perform on the api endpoint
     * @param  string $method
     * @return self
     */
    public function get($method);
    /**
     * execute
     *
     * @return mixed
     */
    public function execute();
}
