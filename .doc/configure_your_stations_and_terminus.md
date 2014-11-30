Configure your stations and terminus
====================================

Stations and Terminus can be configurable. It means that you decide to put
some `metadata` and execute different actions depending on configuration.

## Send configuration to a Station

If you take a look at the `Knp\Minibus\Station` interface, you can see
this method:

```php
public function handle(Minibus $minibus, array $configuration = []);
```

And a simple look on `Knp\Minibus\Line` interface:

```php
public function addStation(Station $station, array $configuration = []);
```

So you can send configuration into your stations like this:

```php
use Knp\Minibus\Line\Line;

$line = new Line;

// SomeStation::handle will receive the given configuration
$line->addStation(new SomeStation, ['some' => 'configuration']);
```

## Send configuration to a terminus

You can do the same thing with a `Knp\Minibus\Terminus`.

```php
use Knp\Minibus\Line\Line;

$line = new Line;

// SomeTerminus::terminate will receive the given configuration
$line->setTerminus(new SomeTerminus, ['some' => 'configuration']);
```

## Defined friendly and solid configuration

If you are regarding on your code quality and maybe you want to create some
generics library using Minibus you will need **friendly and solid configuration**. If you
are not aware of *semantic configuration*, you can take a look on
[the symfony component](http://symfony.com/doc/current/components/config/definition.html).


### Create your configuration

In order to defined the Station or Terminus configuration you will need an instance
of `Symfony\Component\Config\Definition\ConfigurationInterface`.

```php
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

class MyStationConfiguration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder;
        $rootNode = $treeBuilder->root('my_station');

        $rootNode
            ->children()
                ->scalarNode('cat_name')
                    ->defaultValue('Garfield')
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
```

### Plug the configuration into the Station or Terminus

Finally you need to implement the `Knp\Minibus\Configurable\ConfigurableStation` or
the `Knp\Minibus\Configurable\ConfigurableTerminus` interfaces. Let's take an
example with the [`CreateCatStion`](basic_usage.md).

```php
// CreateCatStation.php
use Knp\Minibus\Station;
use Knp\Minibus\Minibus;
use Knp\Minibus\Configurable\ConfigurableStation;

class CreateCatStation implements Station, ConfigurableStation
{
    public function handle(Minibus $minibus, array $configuration)
    {
        // here because we are using MyStationConfiguration the
        // $configuration['cat_name'] will always contains a scalar
        // value. if you don't precised it during the Line::addStation
        // an exception will be throw during the Line::lead
        $name = $configuration['cat_name']

        $minibus->addPassenger('cat', new Cat($name));
    }

    public function getConfiguration()
    {
        return new MyStationConfiguration;
    }
}
```

And voila!
