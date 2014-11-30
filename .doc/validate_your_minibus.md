Validate your minibus
=====================

Minibus comes with a simple validation system. It operates on
`LineEvents::GATE_OPEN` and `LineEvents::GATE_CLOSE` and can validate the
**entering** and **leaving** passengers of a Station.

## Setup

In order to make this validation works, you need to attach a subscriber
to the `Line` dispatcher.


```php
use Knp\Minibus\Line\Line;
use Knp\Minibus\Event\Subscriber\ExpectationStationSubscriber;

$line = new Line;
$line->getDispatcher()->addSubscriber(new ExpectationStationSubscriber);
```

## Validate the entering passengers

If you want to validate the passengers that enter into a `Station` you just
have to implements the interface `Knp\Minibus\Expectation\ResolveEnteringPassengers`.

```php
use Knp\Minibus\Station;
use Knp\Minibus\Excpectation\ResolveEnteringPassengers;
use Knp\Minibus\Minibus;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SomeStation implements Station, ResolveEnteringPassengers
{
    public function setEnteringPassengers(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired(['cat']);
        $resolver->setAllowedTypes(['cat' => 'Cat']);
    }

    public function handle(Minibus $minibus, array $configuration = [])
    {
        $minibus->getPassenger('cat'); // will always return a Cat.
    }
}
```

## Validate the leaving passengers

Like the entering passengers, you can validate the leaving passengers with the
interface `Knp\Minibus\Expectation\ResolveLeavingPassengers`.

```php
use Knp\Minibus\Station;
use Knp\Minibus\Excpectation\ResolveLeavingPassengers;
use Knp\Minibus\Minibus;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SomeStation implements Station, ResolveLeavingPassengers
{
    public function setLeavingPassengers(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired(['other_cat']);
        $resolver->setAllowedTypes(['other_cat' => 'Cat']);
    }

    public function handle(Minibus $minibus, array $configuration = [])
    {
        // this station will fail if we don't defined the other_cat passenger
        $minibus->setPassenger('other_cat', new Cat);
    }
}
```

## Validate both of them

Of course you can choose to validate entering and leaving passengers.

```php
use Knp\Minibus\Station;
use Knp\Minibus\Excpectation\ResolveLeavingPassengers;
use Knp\Minibus\Excpectation\ResolveEnteringPassengers;
use Knp\Minibus\Minibus;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SomeStation implements Station, ResolveLeavingPassengers, ResolveEnteringPassengers
{
    public function setEnteringPassengers(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired(['cat']);
        $resolver->setAllowedTypes(['cat' => 'Cat']);
    }

    public function setLeavingPassengers(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired(['other_cat']);
        $resolver->setAllowedTypes(['other_cat' => 'Cat']);
    }

    public function handle(Minibus $minibus, array $configuration = [])
    {
        $minibus->getPassenger('cat'); // will always return a Cat.

        // this station will fail if we don't defined the other_cat passenger
        $minibus->setPassenger('other_cat', new Cat);
    }
}
```

## You want more?

The last chapter is probably one of the most *powerfull*,
[the configuration](configure_your_stations_and_terminus.md)
