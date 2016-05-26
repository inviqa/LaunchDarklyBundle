Feature: As a developer
  I want to be able to hide features using an if statement
  So that it can be turned on and off

  Scenario: The feature is turned off
    Given the "new-homepage-content" flag is turned off
    When I visit the homepage
    Then I should see "the old homepage content"

  Scenario: The feature is turned off
    Given the "new-homepage-content" flag is turned on
    When I visit the homepage
    Then I should see "the new homepage content"