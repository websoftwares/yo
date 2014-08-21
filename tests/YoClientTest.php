<?php
namespace Websoftwares\Tests\YoClient;
use Websoftwares\YoClient;
/**
 * Class YoClient
 */
class YoClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Yo Api key (UUID?)
     */
    const TEST_KEY  = '550u8400-n29i-41t4-aTEST-446655440000';

    /**
     * $reflection
     * @var object
     */
    protected $reflection;

    public function setUp()
    {
        $this->YoClient = new YoClient(self::TEST_KEY);
        $this->reflection = new \ReflectionClass($this->YoClient);
    }

    public function testInstantiateAsObjectSucceeds()
    {
        $this->assertInstanceOf('Websoftwares\YoClient', $this->YoClient);
    }

    public function testGetCurlOptionsSucceeds()
    {
        $expected = [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FAILONERROR => 1,
            CURLOPT_POST => 0,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_URL => "",
            CURLOPT_USERAGENT => 'Websoftwares Yo PHP client'
        ];
        $method = $this->getMethod('getCurlOptions');
        $actual = $method->invoke($this->YoClient);
        $this->assertEquals($expected,$actual);
    }

    public function testBuildQueryStringSucceeds()
    {
        $expected = "foo=bar";
        $method = $this->getMethod('BuildQueryString');
        $actual = $method->invoke($this->YoClient, array('foo' => 'bar'));
        $this->assertEquals($expected,$actual);
    }

    public function testSetParamsSucceeds()
    {
        $expectedParams = [
            "api_token" => self::TEST_KEY
        ];

        $params = $this->getProperty('params');

        $this->assertInternalType("array",  $params);
        $this->assertEquals($expectedParams, $params);
    }

    /**
     * @expectedException Websoftwares\YoException
     */
    public function testInstantiateAsObjectFails()
    {
        new YoClient;
    }

    public function getMethod($method)
    {
        $method = $this->reflection->getMethod($method);
        $method->setAccessible(true);

        return $method;
    }

    public function getProperty($property)
    {
        $property = $this->reflection->getProperty($property);
        $property->setAccessible(true);

        return $property->getValue($this->YoClient);
    }

    public function setProperty($property, $value)
    {
        $property = $this->reflection->getProperty($property);
        $property->setAccessible(true);

        return $property->setValue($this->YoClient, $value);
    }
}
