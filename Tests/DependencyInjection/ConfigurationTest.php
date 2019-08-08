<?php

namespace Insomnia\MaxMindGeoIpBundle\Tests\DependencyInjection;

use Insomnia\MaxMindGeoIpBundle\DependencyInjection\Configuration;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Definition\Processor;

class ConfigurationTest extends TestCase
{
    public function testConfigurationCompiles()
    {
        $processor = new Processor();
        $processor->processConfiguration(new Configuration(), [
            'insomnia_max_mind_geo_ip' => [
                'path' => '%kernel.root_dir%/geolite2.mmdb'
            ]
        ]);
    }
}
