Insomnia MaxGeoIp Bundle
=======

[![Build Status](https://travis-ci.org/mente/MaxMindGeoIpBundle.svg)](https://travis-ci.org/mente/MaxMindGeoIpBundle)

Installation
====

This bundle helps you deliver MaxMind GeoIp functionality inside your symfony application. Based on [MaxMind library](https://github.com/maxmind/MaxMind-DB-Reader-php).
Installation is same as for other bundles:

    composer require mente/max-mind-geo-ip-bundle *

Don't forget to add bundle in your application kernel:

    <?php
        // app/AppKernel.php

        public function registerBundles()
        {
            $bundles = array(
                // ...
                new \Insomnia\MaxMindGeoIpBundle\InsomniaMaxMindGeoIpBundle(),
            );
        }

Configuration is pretty straight forward:

    insomnia_max_mind_geo_ip:
        #Path to geolite2 database. Default is %kernel.root_dir%/GeoIpCountry.mmdb
        path: %kernel.root_dir%/geolite2.mmdb

After you've finished setting up code, it's time to update the most recent MaxMind database:

    #If you want to use country-precision
    php app/console insomnia:geoip:update http://geolite.maxmind.com/download/geoip/database/GeoLite2-Country.mmdb.gz
    #OR
    #If you want to use city-precision
    #Keep in mind that city-precision database is bigger and it takes a bit longer time to find it by ip.
    php app/console http://geolite.maxmind.com/download/geoip/database/GeoLite2-City.mmdb.gz

Command will save and unpack database to destination specified in configuration. So you don't need to worry about correct placement.

**Hint**: if you want to automate database update, you can integrate it in your composer install/update phase using provided script handler.
Add following to yours `composer.json`:

    "scripts": {
        "post-install-cmd": [
            "Insomnia\\MaxMindGeoIpBundle\\Composer\\ScriptHandler::downloadMaxMindDB"
        ],
        "post-update-cmd": [
            "Insomnia\\MaxMindGeoIpBundle\\Composer\\ScriptHandler::downloadMaxMindDB"
        ]
    },
    "extra": {
        "maxmind-db-path": "app/geolite2.mmdb"
    }

Extra part `maxmind-db-path` is required and should be same as `insomnia_max_mind_geo_ip.path` in symfony configuration. That's it! You're ready to start


Usage
====

Bundle exposes 2 services: `insomnia_max_mind_geo_ip` and `insomnia_max_mind_geo_ip_service`. Former is MaxMind pure database reader itself and latter is
thin wrapper around it with several useful methods. For complete set of methods check `Insomnia\MaxMindGeoIpBundle\Service\GeoIpService`