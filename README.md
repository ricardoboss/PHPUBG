# PHPUBG

![Test Status](https://api.travis-ci.org/MCMainiac/PHPUBG.svg?branch=master)

PHP wrapper for the PUBG Tracker API.

## Installation

PHPUBG is available on [packagist](https://packagist.org/packages/mcmainiac/phpubg), so you can easily require it via composer:

    composer require mcmainiac/phpubg

You can also download this repository as a `.zip` and include the  [`autoload.php`](https://github.com/MCMainiac/PHPUBG/blob/master/src/autoload.php):

    require "path/to/phpubg/src/autoload.php";

## Usage

> To get your own `api key`, please visit [pubgtracker.com/site-api](https://pubgtracker.com/site-api).

Assuming you are at the root of your project (the `vendor` folder is within your current folder):

    <?php

    require __DIR__  . "/vendor/autoload.php";

    use PHPUBG\Region;
    use PHPUBG\PubgBuilder;

    $statsEurope = PubgBuilder::setApiKey("your-api-key")
        ->getPlayer("MCMainiac")
        ->getStats(
            Region::get(Region::EUROPE)
        );

    var_dump($statsEurope);

This should dump all stats available for the player "MCMainiac" in the region "Europe".

You can also use the Steam Id (a 64 bit number) instead of the username. PHPUBG will automatically resolve the username and get the stats:

    <?php
    $builder = PubgBuilder::setApiKey("your-api-key");

    $playerByName = $builder->getPlayer("MCMainiac");
    $playerBySteamId = $builder->getPlayer(76561198128415640); // steam id for "MCMainiac"

    // At this point $playerByName and $playerBySteamId are equivalent entities.

    $playerByName->getNickname() == $playerBySteamID->getNickname(); // will return true

If you want to apply another filter, just pass it to the `getStats` method:

    $player->getStats($region, $season, $mode);

whereas:

- `$region` is an instance from the `\PHPUBG\Region` class or `null`
- `$season` is an instance from the `\PHPUBG\Season` class or `null`
- `$mode` is an instance from the `\PHPUBG\matches\MatchMode` class or `null`

If any variable of the above is `null`, then any value for this filter is accepted.

Example: You want to get all stats for the region "Europe" and the match mode "Solo":

    $region = Region::get(Region::EUROPE);
    $mode = MatchMode::get(MatchMode::SOLO);

    $europeSoloStats = $player->getStats($region, null, $mode);

## Development

Feel free to clone the repository, make your changes and open a pull request.

Please report issues right here on GitHub using the [issues system](https://github.com/MCMainiac/PHPUBG/issues).

## Notes

When requesting stats, please keep the number of requests at ~1/sec.

Thanks to [pubgtracker.com](https://pubgtracker.com) for their public api.

Thanks to all contributors!