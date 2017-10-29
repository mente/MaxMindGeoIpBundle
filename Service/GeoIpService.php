<?php
namespace Insomnia\MaxMindGeoIpBundle\Service;

/**
 * User: avasilenko
 * Date: 29.08.14
 * Time: 10:58
 */
use MaxMind\Db\Reader;

class GeoIpService
{
    /**
     * @var Reader
     */
    private $geoIp;

    public function __construct(Reader $geoIp)
    {
        $this->geoIp = $geoIp;
    }

    /**
     * @param $ip
     * @throws \InvalidArgumentException if ip is invalid
     * @return array
     */
    public function get($ip)
    {
        return $this->geoIp->get($ip);
    }

    public function getContinent($ip)
    {
        $res = $this->geoIp->get($ip);
        if (isset($res['continent'])) {
            return $res['continent'];
        }
        return '';
    }

    public function getContinentCode($ip)
    {
        $res = $this->geoIp->get($ip);
        if (isset($res['continent']['code'])) {
            return $res['continent']['code'];
        }
        return '';
    }

    public function getCountry($ip)
    {
        $res = $this->geoIp->get($ip);
        if (isset($res['country'])) {
            return $res['country'];
        }
        return '';
    }

    public function getCountryCode($ip)
    {
        $res = $this->geoIp->get($ip);
        if (isset($res['country']['iso_code'])) {
            return $res['country']['iso_code'];
        }
        return '';
    }
} 
