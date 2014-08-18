<?php
namespace Websoftwares\Tests\Yo;
use Websoftwares\Yo, Websoftwares\YoClient;
/**
 * Class YoTest
 */
class YoTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $this->Yo = new Yo(new YoClient("1ef5d43b-cffc-eda8-dea5-61c8c2dcf49f"));
    }

    public function testUser()
    {
        var_dump($this->Yo->subscribersCount());
    }
}