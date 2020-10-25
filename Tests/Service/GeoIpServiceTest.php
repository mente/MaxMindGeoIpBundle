<?php
/**
 * User: avasilenko
 * Date: 29.08.14
 * Time: 12:00
 */

namespace Service;


use Insomnia\MaxMindGeoIpBundle\Service\GeoIpService;
use MaxMind\Db\Reader;
use PHPUnit\Framework\TestCase;

class GeoIpServiceTest extends TestCase
{
    const IP_GOOGLE_DNS = '8.8.8.8';
    const MY_IP         = '194.44.211.162';
    const LOCAL_HOST    = '127.0.0.1';

    /**
     * @var GeoIpService
     */
    private $service;
    /**
     * @var Reader
     */
    private $geoIp;

    protected function setUp(): void
    {
        $this->geoIp = new Reader(__DIR__ . '/../geolite2.mmdb');
        $this->service = new GeoIpService($this->geoIp);
    }

    public function testGet()
    {
        $res = $this->service->get(self::IP_GOOGLE_DNS);
        $this->assertNotNull($res, 'Result is invalid');
        $this->assertArrayHasKey('continent', $res, 'Result has continent info');
        $this->assertArrayHasKey('country', $res, 'Result has country info');
    }

    public function testGetCountry()
    {
        $res = $this->service->getCountry(self::IP_GOOGLE_DNS);
        $this->assertNotNull($res, 'Result is invalid');
    }

    public function testGetUnknownContinent()
    {
        $res = $this->service->getContinent(self::LOCAL_HOST);
        $this->assertEquals('', $res);
    }

    public function testGetUnknownContinentCode()
    {
        $res = $this->service->getContinentCode(self::LOCAL_HOST);
        $this->assertEquals('', $res);
    }

    public function testGetUnknownCountry()
    {
        $res = $this->service->getCountry(self::LOCAL_HOST);
        $this->assertEquals('', $res);

    }

    public function testGetUnknownCountryCode()
    {
        $res = $this->service->getCountryCode(self::LOCAL_HOST);
        $this->assertEquals('', $res);

    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testGetInvalidIp()
    {
        $this->service->get('256.255.255.255');
    }

    public function testUkraineIsInEurope()
    {
        $code = $this->service->getContinentCode(self::MY_IP);
        $this->assertEquals('EU', $code, 'Ukraine is not in Europe. Do something');
    }
}
