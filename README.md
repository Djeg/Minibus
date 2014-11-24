Minibus [![Build Status](https://travis-ci.org/Djeg/Minibus.svg)](https://travis-ci.org/Djeg/Minibus) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Djeg/Minibus/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Djeg/Minibus/?branch=master) [![Gitter](https://badges.gitter.im/Join Chat.svg)](https://gitter.im/Djeg/Minibus?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge)
======================================================================================================================================================================================================================================================================================================================================================================================================================

<p style="text-align: center;">
    <img src=".images/minibus.png" alt="minibus" />
</p>

Hey welcome to you traveler! You are looking for a way of traveling through your
software easily? Do not search anymore, you've just find *the* place!

Ladies and gentleman, let me present you the famous, the incredible, the revolutionary
**PHP Minibus** !

## The goal

If you are like me, you are probably coding software solutions. In many software
architectures the story starts with an **Entry point** (cf: a controller in an MVC application). But
if you think about this **Entry Point** you probably agree with
me that it's not only **one point** but, in many cases, a mix of many **components** that interact between them!


In order to avoid what I call **SMFB** architecture (understand: Super Mega
Fuc\*\*\*\* Brain, as the **Controller**) I present you **Minibus**!


The principle is simple. In order to handle an application **Entry Point** we need
three **components**:

- A `Minibus`, which contains various passengers (understand data).
- Some `Stations`, that can handle a minibus at some point (replace the controller).
- Finally a bus `Line` that contains `Stations` and can guide a `Minibus`

## Cool! Let's rock!

A basic example would be somethong like this:

```php
use Knp\Minibus\Station;
use Knp\Minibus\Minibus;

class CrazyStation implements Station
{
    public function handle(Minibus $minibus, array $configuration = [])
    {
        // You can add passenger
        $minibus->addPassenger('Sheldon', ['name' => 'Cooper', 'from' => 'The Big Bang Theory']);

        // Ensure a passenger existence
        if (!$minibus->hasPassenger('Sheldon')) {
            throw new \Exception('Wow something is going wrong :/');
        }

        // Retrieve a passenger
        $from = $minibus->getPassenger('Sheldon')['from'];

        // Or add as many passengers you want
        $minibus->setPassengers([
            'George' => 'Abitbol',
        ]);
    }
}
```

Once you have some stations, you need to create a `Minibus` and a `Line`:


```php
// test.php

use Knp\Minibus\Simple\Minibus;
use Knp\Minibus\Simple\Line;

$minibus = new Minibus;
$line    = new Line;

// add the station in the line
$line->addStation(new CrazyStation);

// finally lead te minibus thrue all the registered stations
$line->lead($minibus); // return the minibus

echo $minibus->getPassenger('George'); // print "Abitbol" :)
```

## Go further

This is some other documentations that explain everything in details:

 - [Basic usage](.doc/basic_usage.md)
 - [Set up terminus](.doc/set_up_a_terminus.md)
 - [Deal with events](.doc/deal_with_events.md)
 - [Validate your minibus](.doc/validate_your_minibus.md)
 - [Configure your stations and terminus](.doc/configure_your_stations_and_terminus.md)
