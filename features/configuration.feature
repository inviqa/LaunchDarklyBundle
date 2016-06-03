Feature: As a developer
  I want to be able to configure launch darkly
  So that it set up correctly for my application

  Scenario: Configuring the API key
    When I ask if a flag is on for a user
    Then the API key I have configured should be used
