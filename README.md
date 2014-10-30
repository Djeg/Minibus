Minibus [![Build Status](https://travis-ci.org/Djeg/Minibus.svg)](https://travis-ci.org/Djeg/Minibus) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Djeg/Minibus/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Djeg/Minibus/?branch=master)
========================================================================================================================================================================================================================================================================

Hey welcome to you traveler! You are looking for a way of traveling through your
software easily? Do not search anymore, you've just find *the* place!

Ladies and gentleman, let me present you the famous, the incredible, the revolutionary
**PHP Minibus** !

## The goal

If you are like me, you are probably coding software solutions. In many software
architectures the story starts with an **Entry point** (cf: a controller in an MVC application). But
if you think about this **Entry Point** you probably agree with
me that it's not only **one point** but, in many cases, a mix of many **components**!


In order to avoid what I call **SMFB** architecture (understand: Super Mega
Fuc\*\*\*\* Brain, as the **Controller**) I present you **Minibus**!


The principle is simple. In order to handle an application **Entry Point** we need
three **components**:

- A `Minibus`, which contains various passengers (understand data).
- Some `Stations`, that can handle a minibus at some point (replace the controller).
- Finally a bus `Line` that contains `Stations` and can be followed by a `Minibus`

## MVC vs MVB (Model View Bus)

To understand the differences between those two patterns here is some wonderful
art illustrating the point:


### The MVC
![MVC Art](.images/MVC.png)

### The MVB
![MVB Art](.images/MVB.png)

## I can't wait! Let's start traveling!

If you're wondering how it is possible to travel through software lands with php, this
is the answer:

```php
<?php

use Symfony\Component\EventDispatcher\EventDispatcher;
use Knp\Minibus\Simple\Line;
use Knp\Minibus\Simple\Minibus;

# Before traveling, we need a bus line
$busLine = new Line(new EventDispatcher);

# Okay, in order to make all the minibus passengers destination we need to create
# Bus stations !
class DreamlandStation implements Station
{
    public function handle(Minibus $minibus)
    {
        // let's interact with the minibus
        $minibus->addPassenger('sheldon', ['name' => 'sheldon']);
    }
}

# Let's add the station to our bus line :
$busLine->addStation(new DreamlandStation);

# Now we just have to follow the bus line with a minibus:
$busLine->follow(new Minibus);
```

## Get more!

TODO
