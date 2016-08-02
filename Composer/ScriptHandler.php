<?php
/**
 * User: avasilenko
 * Date: 29.08.14
 * Time: 13:03
 */

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

        $input = new StringInput('http://geolite.maxmind.com/download/geoip/database/GeoLite2-Country.mmdb.gz');
        $command->run($input, new ConsoleOutput());
    }
}
