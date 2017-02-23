<?php

namespace Insomnia\MaxMindGeoIpBundle\Composer;

use Composer\Script\Event;
use Insomnia\MaxMindGeoIpBundle\Command\LoadDatabaseCommand;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;

class ScriptHandler
{
    public static function downloadMaxMindDB(Event $cmd)
    {
        $options = $cmd->getComposer()->getPackage()->getExtra();
        if (!isset($options['maxmind-db-path'])) {
            throw new \InvalidArgumentException("You should specify 'maxmind-db-path' parameter pointing to geolite2 db path in composer extra.");
        }
        $command = new LoadDatabaseCommand();
        $parameters = new ParameterBag(array('insomnia_max_mind_db_path' => $options['maxmind-db-path']));
        $command->setContainer(new Container($parameters));

        // Allow to provide custom `maxmind-db` database link via `composer.json` extra section
        $maxmindDatabaseLink = isset($options['maxmind-db']) 
            ? $options['maxmind-db'] 
            : 'http://geolite.maxmind.com/download/geoip/database/GeoLite2-Country.mmdb.gz'
        ;
        $input = new StringInput($maxmindDatabaseLink);
        $command->run($input, new ConsoleOutput());
    }
}
