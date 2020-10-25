<?php

namespace Insomnia\MaxMindGeoIpBundle\Tests\Command;

use Insomnia\MaxMindGeoIpBundle\Command\LoadDatabaseCommand;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;

class LoadDatabaseCommandTest extends TestCase
{
    public function testExecute()
    {
        $application = new Application();

        $parameters = new ParameterBag(array('insomnia_max_mind_db_path' => 'Tests/geolite2.mmdb'));
        $application->add(new LoadDatabaseCommand($parameters));

        $command = $application->find('insomnia:geoip:update');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'source' => 'https://download.maxmind.com/app/geoip_download?edition_id=GeoLite2-City&license_key=lapMm8vBb5NREaqL&suffix=tar.gz'
        ]);

        // the output of the command in the console
        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('Unzip completed', $output);
    }
}
