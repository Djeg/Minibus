Set up a terminus!
==================

You probably discover how to travel with Minibus. But what about transforming
the minibus passengers into something else ?


In order to do that you just need to add a `Knp\Minibus\Terminus`
inside your `Knp\Minibus\Line`. To get the **transformed** passengers you
just need to store the result of `Knp\Minibus\Line::lead`.

## You need an example ?

Okay, let's take the famous [cat example](basic_usage.md) seen previously and 
modify it a little bit:

```cucumber
Feature: Feed a cat
    In order to make my cat happy
    As a cat owner
    I should be able to feed it

    Scenario: Successfully feed my cat
        Given I have a cat named Garfield
        When I give him some super meat bowls
        Then Garfield should be fat
        And Garfield should be happy
        And I can sleep
```

Here we can think about transforming the minibus into `spleeping` or `not sleeping`
depending on the cat inside nop?


## The terminus

A terminus is something like this:

```php
use Knp\Minibus\Terminus;
use Knp\Minibus\Minibus;

class SleepingTerminus implements Terminus
{
    public function terminate(Minibus $minibus, array $config)
    {
        if (!$minibus->hasPassenger('cat')) {
            return 'sleeping';
        }

        $cat = $minibus->getPassenger('cat');

        if (!$cat->isHappy() or !$cat->isFat()) {
            return 'not sleeping';
        }

        return 'sleeping';
    }
}
```

## Plug it inside the line

Now we get the terminus we can add it to the line!

```php
// cat_app.php
require 'vendor/autoload.php';

use Knp\Minibus\Line\Line;
use Knp\Minibus\Minibus\Minibus;

// create a minibus, it's like an application container.
$minibus = new Minibus;
// create a line
$line = new Line;

// plug the stations :
$line
    ->addStation(new CreateCatStation('Garfield'))
    ->addStation(new FeedCatStation('super meat bowls'))
;

// Set the terminus
$line->setTerminus(new SleepingTerminus);

// Now the lead will return the terminus result!
$sleeping = $line->lead($minibus);

// assert that your cat is fat, happy and named garfield :-)
assert($minibus->getPassenger('cat')->isHappy());
assert($minibus->getPassenger('cat')->isFat());
assert($minibus->getPassenger('cat')->getName() === 'Garfield');

// assert that we can sleep
assert($sleeping === 'sleeping');
```

## What next?

Discover the [events](deal_with_events.md)
