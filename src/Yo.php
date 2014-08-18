<?php
namespace Websoftwares;
/**
* Yo class with all API methods.
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
    protected $debug = null;

    /**
     * __construct  create class instance
     * @param object $client instance of YoClientInterface
     */
    public function __construct(YoClientInterface $client = null, $debug = null)
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

        return $this->client->post("yoall")->execute();
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

        return $this->client->post("yo")->execute();
    }

    /**
     * subscribersCount return the amount of subscribers
     * @return array
     */
    public function subscribersCount()
    {
        return $this->client->get("subscribers_count")->execute();
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
