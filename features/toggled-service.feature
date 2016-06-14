Feature: As a developer
  I want to be able to toggle a service in config
  So that it can be turned on and off

  Scenario: The service is turned off
    Given the "new-service-content" flag is turned off
    When I visit the service page
    Then I should see "the old service content"

  Scenario: The service is turned off
    Given the "new-service-content" flag is turned on
    When I visit the service page
    Then I should see "the new service content"