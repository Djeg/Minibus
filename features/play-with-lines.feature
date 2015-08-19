Feature: Play with lines
    In order to handle complex actions
    I should be able to create and handle a minibus with a line

    Scenario: Successfully handle a basic minibus line
        Given I create 2 basic stations
        And I create a minibus
        And I create a line instance
        When I add the stations inside the line
        Then I should be able to lead the minibus thrue the lines
        And my minibus should contains the following passengers:
            | basic       |
            | other_basic |

    Scenario: Successfully add a terminus to a line
        Given I create 2 basic stations
        And I create a minibus
        And I create a line instance
        And I create a useless terminus
        When I add the stations inside the line
        And I add the terminus to the line
        Then I should get "useless" when i lead the minibus
        And my minibus should contains the following passengers:
            | basic       |
            | other_basic |

    Scenario: Successfully handle configuration station and terminus
        Given I create a configurable station
        And I create a minibus
        And I create a configurable terminus
        And I create a line instance
        When I add the station inside the line with the configuration:
            | plop | something |
        And I add the terminus to the line with the following configuration:
            | must_return | test |
        Then I should get "test" when i lead the minibus
        And my minibus should contains the following passengers:
            | plop |

    Scenario: Successfully hook a line with events
        Given I create 2 basic stations
        And I create a minibus
        And I create a line with some events
        When I add the stations inside the line
        Then I should be able to lead the minibus thrue the lines
        And my minibus should contains the following passengers:
            | basic       |
            | other_basic |
        And all the line events should have been dispatched

    Scenario: Successfully validate passengers entering and leaving stations
        Given I create a basic station
        And I create a resolvable entering passenger station
        And I create a resolvable leaving passenger station
        And I create a resolvable entering and leaving passenger station
        And I create a minibus
        And I create a line instance
        When I add the expectation station subscriber to the line
        And I add the stations inside the line
        Then I should be able to lead the minibus thrue the lines witheout errors
        But if i configure only the resolvable entering passenger in the line
        Then I should have an error on minibus leading
