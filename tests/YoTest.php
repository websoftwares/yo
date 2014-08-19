<?php
namespace Websoftwares\Tests\Yo;
use Websoftwares\Yo, Websoftwares\YoClient;
/**
 * Class YoTest
 */
class YoTest extends \PHPUnit_Framework_TestCase
{
    CONST TEST_KEY  = '550u8400-n29i-41t4-aTEST-446655440000';

    /**
     * $debug
     * @var boolean
     */
    private $debug = true;

    /**
     * $reflection
     * @var object
     */
    protected $reflection;

    public function setUp()
    {
        $this->Yo = new Yo(new YoClient(self::TEST_KEY), $this->debug);
        $this->reflection = new \ReflectionClass($this->Yo);
    }

    public function testInstantiateAsObjectSucceeds()
    {
        $this->assertInstanceOf('Websoftwares\Yo', $this->Yo);
    }

    public function testClientPropertySucceeds()
    {
        $client = new \stdClass;
        $this->setProperty('client', $client);
        $this->assertEquals($client, $this->getProperty($this->Yo,'client'));
    }

    public function testUserSucceeds()
    {
        $client = $this->Yo->user("BORIS010");

        $expectedParams = [
            "api_token" => self::TEST_KEY,
            "username" => "BORIS010"
        ];

        $expectedCurlOptions = [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FAILONERROR => 1,
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $expectedParams,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_URL => "http://api.justyo.co/yo/",
            CURLOPT_USERAGENT => 'Websoftwares Yo PHP client'
        ];

        $params = $this->getProperty($client,'params');

        $this->assertInternalType("array",  $params);
        $this->assertEquals($expectedParams, $params);

        $curlOptions = $this->getProperty($client,'curlOptions');

        $this->assertInternalType("array",  $curlOptions);
        $this->assertEquals($expectedCurlOptions, $curlOptions);
    }

    public function testUserLinkSucceeds()
    {
        $client = $this->Yo->user("BORIS010", "http://yo.websoftwar.es");

        $expectedParams = [
            "api_token" => self::TEST_KEY,
            "username" => "BORIS010",
            "link" => "http://yo.websoftwar.es"
        ];

        $expectedCurlOptions = [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FAILONERROR => 1,
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $expectedParams,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_URL => "http://api.justyo.co/yo/",
            CURLOPT_USERAGENT => 'Websoftwares Yo PHP client'
        ];

        $params = $this->getProperty($client,'params');

        $this->assertInternalType("array",  $params);
        $this->assertEquals($expectedParams, $params);

        $curlOptions = $this->getProperty($client,'curlOptions');

        $this->assertInternalType("array",  $curlOptions);
        $this->assertEquals($expectedCurlOptions, $curlOptions);
    }

    public function testAllSucceeds()
    {
        $client = $this->Yo->all();

        $expectedParams = [
            "api_token" => self::TEST_KEY
        ];

        $expectedCurlOptions = [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FAILONERROR => 1,
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $expectedParams,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_URL => "http://api.justyo.co/yoall/",
            CURLOPT_USERAGENT => 'Websoftwares Yo PHP client'
        ];

        $params = $this->getProperty($client,'params');

        $this->assertInternalType("array",  $params);
        $this->assertEquals($expectedParams, $params);

        $curlOptions = $this->getProperty($client,'curlOptions');

        $this->assertInternalType("array",  $curlOptions);
        $this->assertEquals($expectedCurlOptions, $curlOptions);
    }

    public function testAllLinkSucceeds()
    {
        $client = $this->Yo->all("http://yo.websoftwar.es");

        $expectedParams = [
            "api_token" => self::TEST_KEY,
            "link" => "http://yo.websoftwar.es"
        ];

        $expectedCurlOptions = [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FAILONERROR => 1,
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $expectedParams,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_URL => "http://api.justyo.co/yoall/",
            CURLOPT_USERAGENT => 'Websoftwares Yo PHP client'
        ];

        $params = $this->getProperty($client,'params');

        $this->assertInternalType("array",  $params);
        $this->assertEquals($expectedParams, $params);

        $curlOptions = $this->getProperty($client,'curlOptions');

        $this->assertInternalType("array",  $curlOptions);
        $this->assertEquals($expectedCurlOptions, $curlOptions);
    }

    public function testSubscribersCountSucceeds()
    {

        $client = $this->Yo->subscribersCount();

        $expectedParams = [
            "api_token" => self::TEST_KEY,
        ];

        $expectedCurlOptions = [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FAILONERROR => 1,
            CURLOPT_POST => 0,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_URL => "http://api.justyo.co/subscribers_count/?api_token=550u8400-n29i-41t4-aTEST-446655440000",
            CURLOPT_USERAGENT => 'Websoftwares Yo PHP client'
        ];

        $params = $this->getProperty($client,'params');

        $this->assertInternalType("array",  $params);
        $this->assertEquals($expectedParams, $params);

        $curlOptions = $this->getProperty($client,'curlOptions');

        $this->assertInternalType("array",  $curlOptions);
        $this->assertEquals($expectedCurlOptions, $curlOptions);
    }

    /**
     * @expectedException Websoftwares\YoException
     */
    public function testInstantiateAsObjectFails()
    {
        new Yo;
    }

    public function getMethod($method)
    {
        $method = $this->reflection->getMethod($method);
        $method->setAccessible(true);

        return $method;
    }

    public function getProperty($object, $property)
    {
        $reflection = new \ReflectionClass($object);
        $property = $reflection->getProperty($property);
        $property->setAccessible(true);

        return $property->getValue($object);
    }

    public function setProperty($property, $value)
    {
        $property = $this->reflection->getProperty($property);
        $property->setAccessible(true);

        return $property->setValue($this->Yo, $value);
    }
}