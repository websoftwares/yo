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

    public function testPropertySucceeds()
    {
        $expectedParams = [
            "api_token" => self::TEST_KEY
        ];
        $this->assertEquals($expectedParams, $this->getProperty('params'));
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

    public function testSetCurlOptionsSucceeds()
    {

        $this->YoClient->setCurlOption(CURLOPT_RETURNTRANSFER, 0);

        $expected = [
            CURLOPT_RETURNTRANSFER => 0,
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

    public function testSetParamSucceeds()
    {

        $this->YoClient->setParams("xxx", self::TEST_KEY);
        $expectedParams = [
            "xxx" => self::TEST_KEY,
            "api_token" => self::TEST_KEY
        ];

        $params = $this->getProperty('params');

        $this->assertInternalType("array",  $params);
        $this->assertEquals($expectedParams, $params);
    }

    public function testGetParamsSucceeds()
    {

        $this->YoClient->setParams("xxx", self::TEST_KEY);

        $expected = [
            "xxx" => self::TEST_KEY,
            "api_token" => self::TEST_KEY
        ];

        $method = $this->getMethod('getParams');
        $actual = $method->invoke($this->YoClient);

        $this->assertEquals($expected, $actual);

    }

    public function testPostSucceeds()
    {
        $expectedParams = [
            "api_token" => self::TEST_KEY
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

        $this->YoClient->post("yo");
        $params = $this->getProperty('params');

        $this->assertInternalType("array",  $params);
        $this->assertEquals($expectedParams, $params);

        $curlOptions = $this->getProperty('curlOptions');

        $this->assertInternalType("array",  $curlOptions);
        $this->assertEquals($expectedCurlOptions, $curlOptions);
    }

    public function testGetSucceeds()
    {
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

        $this->YoClient->get("subscribers_count");
        $params = $this->getProperty('params');

        $this->assertInternalType("array",  $params);
        $this->assertEquals($expectedParams, $params);

        $curlOptions = $this->getProperty('curlOptions');

        $this->assertInternalType("array",  $curlOptions);
        $this->assertEquals($expectedCurlOptions, $curlOptions);
    }

    public function testExecuteSuccessResponseStub()
    {
        $actual = new \stdClass();
        $actual->result = 1;

        $stub = $this->getMockBuilder('\Websoftwares\\YoClient')
             ->setConstructorArgs([self::TEST_KEY])
             ->getMock();

        $stub->expects($this->once())
             ->method('execute') // method name
             ->will($this->returnValue($actual)); // return value

        $this->assertEquals($actual, $stub->execute());
    }

    /**
     * @expectedException Websoftwares\YoException
     */
    public function testInstantiateAsObjectFails()
    {
        new YoClient();
    }

    /**
     * @expectedException Websoftwares\YoException
     */
    public function testExecuteFails()
    {
        $this->YoClient->get("subscribers_count")->execute();
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
