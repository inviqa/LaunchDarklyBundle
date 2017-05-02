Feature: As a developer
  I want to be able to explicitly create the user when it is not available implicitly
  So that I can use feature flags in apps with no session

  Scenario: The feature is turned off
    Given the "new-homepage-user-content" flag is turned off
    When I visit the explicit user homepage
    Then I should see "the old homepage user content"

  Scenario: The feature is turned on
    Given the "new-homepage-user-content" flag is turned on
    When I visit the explicit user homepage
    Then I should see "the new homepage user content"

  Scenario: The feature is turned off checking using a static method
    Given the "new-static-access-user-content" flag is turned off
    When I visit the explicit user static method page
    Then I should see "the old static access user content"

  Scenario: The feature is turned on checking using a static method
    Given the "new-static-access-user-content" flag is turned on
    When I visit the explicit user static method page
    Then I should see "the new static access user content"