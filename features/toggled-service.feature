Feature: As a developer
  I want to be able to toggle a service in config
  So that it can be turned on and off

  Scenario: The injected service flag is turned off
    Given the "new-service-content" flag is turned off
    When I visit the service page
    Then I should see "the old service content"

  Scenario: The injected service flag is turned on
    Given the "new-service-content" flag is turned on
    When I visit the service page
    Then I should see "the new service content"

  Scenario: The aliased service flag is turned off
    Given the "new-aliased-service-content" flag is turned off
    When I visit the aliased service page
    Then I should see "the old service content"

  Scenario: The aliased service flag is turned on
    Given the "new-aliased-service-content" flag is turned on
    When I visit the aliased service page
    Then I should see "the new service content"

  Scenario: The tagged service flag is turned off
    Given the "new-tagged-service-content" flag is turned off
    When I visit the tagged service page
    Then I should see "the old service content"

  Scenario: The tagged service flag is turned on
    Given the "new-tagged-service-content" flag is turned on
    When I visit the tagged service page
    Then I should see "the new service content"