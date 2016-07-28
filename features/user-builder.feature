Feature: As a developer
  I want to be able to configure how the laucnhdarkly user is built
  So that I can use the correct details

  Scenario: The user key is provided by a custom user key provider
    Given I fix the user key to "12345"
    When I visit the homepage
    Then "12345" should have been used to identify me

  Scenario: The user is provided by a custom user factory
    Given I fix the user ip to "127.1.1.1"
    When I visit the homepage
    Then "127.1.1.1" should have been used as the ip address
