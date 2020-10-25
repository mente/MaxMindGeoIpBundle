<?php

namespace Insomnia\MaxMindGeoIpBundle\Command;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

/**
 * User: avasilenko
 * Date: 29.08.14
 * Time: 11:27
 */
class LoadDatabaseCommand extends Command
{
    private $params;

    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
    }

    protected function configure()
    {
        $this
            ->setName('insomnia:geoip:update')
            ->setDescription('Update the MaxMind GeoIp data')
            ->addArgument(
                'source',
                InputArgument::REQUIRED,
                'The url source file to download and unzip')
            ->setHelp(<<<EOT
The <info>%command.name%</info> command download and install the MaxMind GeoIp data source

To install the GeoLiteCountry:
<info>php %command.full_name% http://geolite.maxmind.com/download/geoip/database/GeoLite2-Country.mmdb.gz</info>

To install the GeoLite City:
<info>php %command.full_name% http://geolite.maxmind.com/download/geoip/database/GeoLite2-City.mmdb.gz</info>

more information here: http://dev.maxmind.com/geoip/geoip2/geolite2/

EOT
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $source = $input->getArgument('source');

        $tmpFile = tempnam(sys_get_temp_dir(), 'maxmind_geoip');
        $destination = $this->params->get('insomnia_max_mind_db_path');
        $output->writeln(sprintf('<info>Start downloading %s</info>', $source));
        $output->writeln('...');

        if (!copy($source, $tmpFile)) {
            $output->writeln('<error>Error during file download occurred</error>');
            return;
        }

        $output->writeln('<info>Download completed</info>');
        $output->writeln('Unzip the downloading data');
        $output->writeln('...');
        $res = -1;
        $gzOutput = '';
        $cmd = 'gunzip < ' . escapeshellarg($tmpFile) . ' > ' . escapeshellarg($destination);
        exec($cmd, $gzOutput, $res);
        if ($res != 0) {
            $output->writeln('<error>Unable to ungzip file</error>');
            $output->writeln(sprintf('<error>Command: %s</error>', $cmd));
            $output->writeln(sprintf('<error>Output: %s</error>', implode("\n", $gzOutput)));
        } else {
            $output->writeln('<info>Unzip completed</info>');
        }
    }
}
