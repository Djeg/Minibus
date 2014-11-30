Deal with event
===============

A `Line` during its lifecycle dispatch some events. It's really usefull when
you want to *hook* a specific behavior.

## Retrieve the dispatcher

When you create a `Line` you can precise your own dispatcher:

```php
use Knp\Minibus\Line\Line;
use Symfony\Component\EventDispatcher\EventDispatcher;

$dispatcher = new EventDispatcher;
$line = new Line($dispatcher);

// you can retrieve and use the dispatcher:
$line->getDispatcher();
```

## The LineEvents

A complete list of events are stored inside `Knp\Minibus\Event\LineEvents`. But
this is the list (attach to their own `Event` instance).

| Event                    | Instance                          | Description                                     |
| ------------------------ | --------------------------------- | ----------------------------------------------- |
| `LineEvents::START`      | `Knp\Minibus\Event\StartEvent`    | Raised before the line is leaded                |
| `LineEvents::GATE_OPEN`  | `Knp\Minibus\Event\GateEvent`     | Raised just before a minibus enter in a station |
| `LineEvents::GATE_CLOSE` | `Knp\Minibus\Event\GateEvent`     | Raised when a minibus leave a station           |
| `LineEvents::TERMINUS`   | `Knp\Minibus\Event\TerminusEvent` | Raised before a minibus terminate               |

## What next ?

Next part is about [validation](validate_your_minibus.md).
