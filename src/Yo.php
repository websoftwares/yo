<?php
namespace Websoftwares;
/**
* Yo wrapper class with all API methods.
*
* @package Websoftwares
* @license http://opensource.org/licenses/MIT
* @author Boris <boris@websoftwar.es>
*/
class Yo
{
    /**
     * $client
     * @var YoClientInterface
     */
    protected $client = null;
    /**
     * $debug
     * @var boolean
     */
    protected $debug = false;
    /**
     * __construct  create class instance
     * @param object $client instance of YoClientInterface
     */
    public function __construct(YoClientInterface $client = null, $debug = false)
    {
        if (! $client) {
            throw new YoException('A client must be provided');
        }
        $this->client = $client;
        $this->debug = $debug;
    }

    /**
     * all     send a Yo to all subscribers
     * @return array
     */
    public function all($link = null)
    {
        if ($link) {
            $this->client->setParams("link", $link);
        }

        // Setup client
        $this->client->post("yoall");

        // For testing
        if (! $this->debug) {
            return $this->client->execute();
        } else {
            return $this->client;
        }
    }

    /**
     * user    send a Yo individual usernames with optional link
     * @param  string $username (required) the username to Yo
     * @param  string $link     (optional) the link to attach to a Yo!
     * @return array
     */
    public function user($username = null, $link = null)
    {
        if (! $username) {
            throw new YoException("A username is required to send a Yo");
        }

        $this->client->setParams("username", $username);

        if ($link) {
            $this->client->setParams("link", $link);
        }

        // Setup client
        $this->client->post("yo");

        // For testing
        if (! $this->debug) {
            return $this->client->execute();
        } else {
            return $this->client;
        }
    }

    /**
     * subscribersCount return the amount of subscribers
     * @return array
     */
    public function subscribersCount()
    {
        // Setup client
        $this->client->get("subscribers_count");

        // For testing
        if (! $this->debug) {
            return $this->client->execute();
        } else {
            return $this->client;
        }
    }

    /**
     * __call  overloading client methods
     * @param  string $method
     * @param  mixed  $args
     * @return mixed
     */
    public function __call($method, $args)
    {
        if (! method_exists($this,$method)) {
            call_user_func_array(array($this->client, $method), $args);

            return $this;
        }
    }
}
