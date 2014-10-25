Minibus
=======

Hey welcome to you traveler! You are looking for a way of traveling thrue your
sotware easily ? Do not search anymore, you've just find **the** place!

Ladies and gentleman, let me present the famous, the incredible, the revolutionary
**PHP Minibus** !

## I can't wait ! Let's start traveling !

You're wondering how it is possible to travel thrue software lands with php, this
is the answer :

```php
use Symfony\Component\EventDispatcher\EventDispatcher;
use Knp\Minibus\Simple\Line;
use Knp\Minibus\Simple\Minibus;

# Before traveling, we need a bus line
$busLine = new Line(new EventDispatcher);

# Okay in order to make all the minibus passengers destination we need to create
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

# Now we just have to follow the bus line with a minibus :
$busLine->follow(new Minibus);
```

## Getting more !

TODO
