Feature: As a developer
  I want to be able to toggle a feature in a twig template
  So that it can be turned on and off

  Scenario: The feature is turned off
    Given the "new-template-content" flag is turned off
    When I visit the template page
    Then I should see "the old template content"

  Scenario: The feature is turned off
    Given the "new-template-content" flag is turned on
    When I visit the template page
    Then I should see "the new template content"