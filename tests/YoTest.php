<?php
namespace Websoftwares\Tests\Yo;
use Websoftwares\Yo, Websoftwares\YoClient;
/**
 * Class YoTest
 */
class YoTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Yo Api key (UUID?)
     */
    const TEST_KEY  = '550u8400-n29i-41t4-aTEST-446655440000';

    public function setUp()
    {
        $this->Yo = new Yo(new YoClient(self::TEST_KEY));
    }

    public function testInstantiateAsObjectSucceeds()
    {
        $this->assertInstanceOf('Websoftwares\Yo', $this->Yo);
    }

    public function testAllSucceeds()
    {
        $response = [];

        $YoClient = $this->getMock("Websoftwares\YoClient", ["execute"], [self::TEST_KEY]);

        $YoClient->expects($this->any())
            ->method('execute')
            ->will($this->returnCallback(function () use (&$response) {
                $response[] = '{}';
            }));

        $YoAll = (new Yo($YoClient))->all();
        $YoAllLink = (new Yo($YoClient))->all("http://yo.websoftwar.es");

        $expected = new \stdClass();

        $this->assertEquals($expected, json_decode($response[0]));
        $this->assertEquals($expected, json_decode($response[1]));
    }

    public function testUserSucceeds()
    {
        $response = [];

        $YoClient = $this->getMock("Websoftwares\YoClient", ["execute"], [self::TEST_KEY]);

        $YoClient->expects($this->any())
            ->method('execute')
            ->will($this->returnCallback(function () use (&$response) {
                $response[] = '{"result": "OK"}';
            }));

        $YoUser = (new Yo($YoClient))->user("BORIS010");
        $YoUserLink = (new Yo($YoClient))->user("BORIS010", "http://yo.websoftwar.es");

        $expected = new \stdClass();
        $expected->result = "OK";

        $this->assertEquals($expected, json_decode($response[0]));
        $this->assertEquals($expected, json_decode($response[1]));
    }

    public function testSubscribersCountSucceeds()
    {
        $response = [];

        $YoClient = $this->getMock("Websoftwares\YoClient", ["execute"], [self::TEST_KEY]);

        $YoClient->expects($this->any())
            ->method('execute')
            ->will($this->returnCallback(function () use (&$response) {
                $response[] = '{"result": 1}';
            }));

        $subscribersCount = (new Yo($YoClient))->subscribersCount();

        $expected = new \stdClass();
        $expected->result = 1;

        $this->assertEquals($expected, json_decode($response[0]));
    }

    /**
     * @expectedException Websoftwares\YoException
     */
    public function testInstantiateAsObjectFails()
    {
        new Yo();
    }

    /**
     * @expectedException Websoftwares\YoException
     */
    public function testUserFails()
    {
        $this->Yo->user();
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
