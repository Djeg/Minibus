<?php

namespace Context;

use example\Knp\Minibus\Station\BasicStation;
use example\Knp\Minibus\Station\SomeConfigurableStation;
use example\Knp\Minibus\Station\OtherBasicStation;
use example\Knp\Minibus\Station\ResolvableEnteringStation;
use example\Knp\Minibus\Station\ResolvableLeavingStation;
use example\Knp\Minibus\Station\ResolvableEnteringAndLeavingStation;
use example\Knp\Minibus\Terminus\UselessTerminus;
use example\Knp\Minibus\Terminus\SomeConfigurableTerminus;
use Knp\Minibus\Minibus\Minibus;
use Knp\Minibus\Line\Line;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\TableNode;
use Behat\Behat\Hook\Call\AfterScenario;
use Knp\Minibus\Event\LineEvents;
use Knp\Minibus\Event\Subscriber\ExpectationStationSubscriber;
use Knp\Minibus\Terminus\JmsSerializerTerminus;
use JMS\Serializer\SerializerBuilder;
use Behat\Gherkin\Node\PyStringNode;
use Knp\Minibus\Terminus\TwigTemplateTerminus;
use Knp\Minibus\Terminus\HttpWrapperTerminus;
use Symfony\Component\HttpFoundation\Response;

class MinibusLibraryContext implements SnippetAcceptingContext
{
    public static $stations = [];

    public static $minibus;

    public static $line;

    public static $terminus;

    public static $raisedEvents;

    /**
     * @Given I create 2 basic stations
     */
    public function createTwoBasicStations()
    {
        self::$stations[] = new BasicStation();
        self::$stations[] = new OtherBasicStation();
    }

    /**
     * @Given I create a basic station
     */
    public function createBasicStation()
    {
        self::$stations[] = new BasicStation();
    }

    /**
     * @Given I create a resolvable entering passenger station
     */
    public function createEnteringResolvableStation()
    {
        self::$stations[] = new ResolvableEnteringStation();
    }

    /**
     * @Given I create a resolvable leaving passenger station
     */
    public function createLeavingPassengerStation()
    {
        self::$stations[] = new ResolvableLeavingStation();
    }

    /**
     * @Given I create a resolvable entering and leaving passenger station
     */
    public function createEnteringAndLeavingStation()
    {
        self::$stations[] = new ResolvableEnteringAndLeavingStation();
    }

    /**
     * @Given I create a configurable station
     */
    public function createConfigurableStation()
    {
        self::$stations   = [];
        self::$stations[] = new SomeConfigurableStation();
    }

    /**
     * @Given I create a minibus
     */
    public function createMinibus()
    {
        self::$minibus = new Minibus();
    }

    /**
     * @Given I create a line
     */
    public function createLine()
    {
        self::$line = new Line();
    }

    /**
     * @Given I create a line with some events
     */
    public function createLineWithEvents()
    {
        self::$raisedEvents = [
            LineEvents::START      => false,
            LineEvents::GATE_OPEN  => false,
            LineEvents::GATE_CLOSE => false,
            LineEvents::TERMINUS   => false,
        ];

        self::$line = new Line();

        foreach (array_keys(self::$raisedEvents) as $eventName) {
            self::$line->getDispatcher()->addListener($eventName, function () use ($eventName) {
                MinibusLibraryContext::$raisedEvents[$eventName] = true;
            });
        }
    }

    /**
     * @Given I create a useless terminus
     */
    public function createUselessTerminus()
    {
        self::$terminus = new UselessTerminus();
    }

    /**
     * @Given I create a configurable terminus
     */
    public function createConfigurableTerminus()
    {
        self::$terminus = new SomeConfigurableTerminus();
    }

    /**
     * @Given I create a jms serializer terminus
     */
    public function createJmsSerializerTerminus()
    {
        self::$terminus = new JmsSerializerTerminus(SerializerBuilder::create()->build());
    }

    /**
     * @Given I create a twig template terminus
     */
    public function createTwigTemplateTerminus()
    {
        self::$terminus = new TwigTemplateTerminus(
            new \Twig_Environment(new \Twig_Loader_String())
        );
    }

    /**
     * @Given I create an http wrapped twig template terminus
     */
    public function createAnHttpWrappedTwigTerminus()
    {
        self::$terminus = new HttpWrapperTerminus(new TwigTemplateTerminus(
            new \Twig_Environment(new \Twig_Loader_String())
        ));
    }

    /**
     * @When I add the stations to the line
     */
    public function addStations()
    {
        foreach (self::$stations as $station) {
            self::$line->addStation($station);
        }
    }

    /**
     * @When I add the station to the line with the configuration:
     */
    public function addStationAndConfigure(TableNode $table)
    {
        self::$line->addStation(self::$stations[0], $table->getRowsHash());
    }

    /**
     * @When I add the terminus to the line with the following json configuration:
     */
    public function addWrappedTerminusWithConfiguration(PyStringNode $node)
    {
        $configuration = json_decode($node->getRaw(), true);

        self::$line->setTerminus(self::$terminus, $configuration);
    }

    /**
     * @When I add the terminus to the line with the following template:
     */
    public function addTemplateTerminus(PyStringNode $templateNode)
    {
        self::$line->setTerminus(self::$terminus, [
            'template' => $templateNode->getRaw(),
        ]);
    }

    /**
     * @When I add the terminus to the line
     */
    public function addTerminus()
    {
        self::$line->setTerminus(self::$terminus);
    }

    /**
     * @When I add the terminus to the line with the following configuration:
     */
    public function addTerminusAndConfigure(TableNode $table)
    {
        self::$line->setTerminus(self::$terminus, $table->getRowsHash());
    }

    /**
     * @When I add the expectation station subscriber to the line
     */
    public function addExpectationStationSubscriber()
    {
        self::$line->getDispatcher()->addSubscriber(new ExpectationStationSubscriber());
    }

    /**
     * @Then /^I should be able to lead the minibus through the line( without errors)?$/
     */
    public function leadMinibus()
    {
        $minibus = self::$line->lead(self::$minibus);

        expect($minibus)->toBe(self::$minibus);
    }

    /**
     * @Then if i configure only the resolvable entering passenger in the line
     */
    public function iConfigureOnlyResolvableEnteringPessenger()
    {
        self::$line = new Line();
        $this->addExpectationStationSubscriber();

        self::$line->addStation(new ResolvableEnteringStation());
    }

    /**
     * @Then I should get ":message" when I lead the minibus
     */
    public function shouldGetOnLead($message)
    {
        expect(self::$line->lead(self::$minibus))->toBe($message);
    }

    /**
     * @Then my minibus should contain the following passengers:
     */
    public function minibusShouldContain(TableNode $table)
    {
        $passengers = array_keys($table->getRowsHash());

        foreach ($passengers as $passenger) {
            expect(self::$minibus->hasPassenger($passenger))->toBe(true);
        }
    }

    /**
     * @Then all the line events should have been dispatched
     */
    public function allEventsShouldBeDispatched()
    {
        foreach (self::$raisedEvents as $raised) {
            expect($raised)->toBe(true);
        }
    }

    /**
     * @Then I should have an error on minibus leading
     */
    public function iShouldHaveAnErrorOnMinibusLeading()
    {
        expect(function () {
            MinibusLibraryContext::$line->lead(MinibusLibraryContext::$minibus);
        })->toThrow('Knp\Minibus\Exception\MissingPassengerException');
    }

    /**
     * @Then I should get the following json when the bus is led:
     */
    public function assertJsonEquals(PyStringNode $node)
    {
        $rawJson = self::$line->lead(self::$minibus);

        expect(json_decode($rawJson, true))->toBe(json_decode($node->getRaw(), true));
    }

    /**
     * @Then I should get the following string when the bus is led:
     */
    public function expectLineToReturnTemplate(PyStringNode $node)
    {
        expect(self::$line->lead(self::$minibus))->toBe($node->getRaw());
    }

    /**
     * @Then I should receive a 200 response with the following content:
     */
    public function iShouldReceiveResponseWithContent(PyStringNode $node)
    {
        $response = self::$line->lead(self::$minibus);

        expect($response instanceof Response)->toBe(true);

        expect($response->getContent())->toBe($node->getRaw());
    }

    /**
     * @AfterScenario
     */
    public function clean()
    {
        self::$stations     = [];
        self::$minibus      = null;
        self::$line         = null;
        self::$terminus     = null;
        self::$raisedEvents = [];
    }
}
