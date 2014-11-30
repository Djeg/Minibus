Basic usage
===========

## Installation

We **recommend** to use *composer* for the installation. Like this :

```
$ php composer.phar require knplabs/minibus
```

That's it.

## An exemple!

This is some basic usage details. In order to create an *application workflow* you need some components:

1. Instances of `Knp\Minibus\Station`
2. One instance of a `Knp\Minibus\Minibus`
3. One instance of a line `Knp\Minibus\Line`

Let's take real life example with the following feature:

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
```

### Step 1, create the cat

```php
// Cat.php
class Cat
{
    private $happy = false;

    private $fat = false;

    private $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function eat($food)
    {
        if ($food === 'super meat bowls') {
            $this->happy = true;
            $this->fat   = true;
        }
    }

    public function isHappy()
    {
        return $this->happy;
    }

    public function isFat()
    {
        return $this->fat;
    }

    public function getName()
    {
        return $this->name;
    }
}
```

### Step 2, the application workflow

```php
// cat_app.php
require 'vendor/autoload.php';

use Knp\Minibus\Line\Line;
use Knp\Minibus\Minibus\Minibus;

// create a minibus, it's like an application container.
$minibus = new Minibus;
// create a line
$line = new Line;

// plug your stations here, see next section.

// finally lead the minibus thrue the end of the line:
$line->lead($minibus);

// assert that your cat is fat, happy and named garfield :-)
assert($minibus->getPassenger('cat')->isHappy());
assert($minibus->getPassenger('cat')->isFat());
assert($minibus->getPassenger('cat')->getName() === 'Garfield');
```

### Step 3, the stations

Each `Knp\Minibus\Station` represent a **step** in your  **application workflow**. For exemple, in
the previous feature, we can detect those 2 **steps** :

- `I have a cat named Garfield`
- `I give him some super meat bowls`

Let's create them:

```php
// CreateCatStation.php
use Knp\Minibus\Station;
use Knp\Minibus\Minibus;

class CreateCatStation implements Station
{
    private $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function handle(Minibus $minibus, array $configuration)
    {
        $minibus->addPassenger('cat', new Cat($this->name));
    }
}
```

```php
// FeedCatStation.php
use Knp\Minibus\Station;
use Knp\Minibus\Minibus;

class FeedCatStation implements Station
{
    private $food;

    public function __construct($food)
    {
        $this->food = $food;
    }

    public function handle(Minibus $minibus, array $configuration)
    {
        $cat = $minibus->getPassenger('cat');

        $cat->eat($this->food);
    }
}
```

### Step 4, finalized the bus line ^.^

Let's add some stations inside our previously created `Line`:

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

// finally lead the minibus thrue the end of the line:
$line->lead($minibus);

// assert that your cat is fat, happy and named garfield :-)
assert($minibus->getPassenger('cat')->isHappy());
assert($minibus->getPassenger('cat')->isFat());
assert($minibus->getPassenger('cat')->getName() === 'Garfield');
```

### Enjoy!

Garfield should be happy and not hungry anymore! Well done!


The important thing is to understant that a line will **contains**
`Knp\Minibus\Station` and during the `Knp\Minibus\Line\Line::lead` will
execute all the registered `Knp\Minibus\Station` in the **same order** as you
declare them.


## Get more and discover the Terminus.

Wut o_O ? A [terminus](set_up_a_terminus.md) ?
