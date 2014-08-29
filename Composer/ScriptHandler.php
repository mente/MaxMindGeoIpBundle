<?php
/**
 * User: avasilenko
 * Date: 29.08.14
 * Time: 13:03
 */

namespace Insomnia\MaxMindGeoIpBundle\Composer;


use Insomnia\MaxMindGeoIpBundle\Command\LoadDatabaseCommand;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;
use Composer\Script\CommandEvent;

class ScriptHandler
{
    public static function downloadMaxMindDB(CommandEvent $cmd)
    {
        $options = $cmd->getComposer()->getPackage()->getExtra();
        $command = new LoadDatabaseCommand();
        $parameters = new ParameterBag(['insomnia_max_mind_db_path' => $options['maxmind-db-path']]);
        $command->setContainer(new Container($parameters));

        $input = new StringInput('http://geolite.maxmind.com/download/geoip/database/GeoLite2-Country.mmdb.gz');
        $command->run($input, new ConsoleOutput());
    }
} 