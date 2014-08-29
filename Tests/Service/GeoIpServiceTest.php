<?php
/**
 * User: avasilenko
 * Date: 29.08.14
 * Time: 12:00
 */

namespace Service;


use Insomnia\MaxMindGeoIpBundle\Service\GeoIpService;
use MaxMind\Db\Reader;

class GeoIpServiceTest extends \PHPUnit_Framework_TestCase
{
    const IP_GOOGLE_DNS = '8.8.8.8';
    /**
     * @var GeoIpService
     */
    private $service;
    /**
     * @var Reader
     */
    private $geoIp;

    protected function setUp()
    {
        $this->geoIp = new Reader(__DIR__ . '/../GeoLite2-Country.mmdb');
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

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testGetInvalidIp()
    {
        $this->service->get('256.255.255.255');
    }
} 