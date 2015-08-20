Feature: In order to display a minibus
    I should be able to configure terminus

    Scenario: Successfully serialize minibus passengers
        Given I create 2 basic stations
        And I create a minibus
        And I create a line
        And I create a jms serializer terminus
        When I add the stations to the line
        And I add the terminus to the line
        Then I should get the following json when the bus is led:
        """
        {
            "basic": true,
            "other_basic": true
        }
        """

    Scenario: Successfully render a minibus with a twig template
        Given I create 2 basic stations
        And I create a minibus
        And I create a line
        And I create a twig template terminus
        When I add the stations to the line
        And I add the terminus to the line with the following template:
        """
        {% if basic %}Basic{% else %}No basic{% endif %} and {% if other_basic %}Other basic{% else %}no Other basic{% endif %}
        """
        Then I should get the following string when the bus is led:
        """
        Basic and Other basic
        """

    Scenario: I can wrap a minibus terminus into an http response
        Given I create 2 basic stations
        And I create a minibus
        And I create a line
        And I create an http wrapped twig template terminus
        When I add the stations to the line
        And I add the terminus to the line with the following json configuration:
        """
        {
            "template": "{% if basic %}Basic{% else %}No basic{% endif %} and {% if other_basic %}Other basic{% else %}no Other basic{% endif %}",
            "headers": {
                "Content-Type": "text/html"
            }
        }
        """
        Then I should receive a 200 response with the following content:
        """
        Basic and Other basic
        """
