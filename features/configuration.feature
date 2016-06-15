Feature: As a developer
  I want to be able to configure launch darkly
  So that it set up correctly for my application

  Scenario: Setting requester using the config file
    When I ask if a flag is on for a user
    Then the requester I have configured should be used

  Scenario: Setting defaults using the config file
    Given I have configured defaults
    When I ask if a flag is on for a user
    Then the defaults I have configured should be used

  Scenario Outline: Setting configuration options using the config file
    Given I have configured "<option>" of "<type>" as "<value>"
    When I ask if a flag is on for a user
    Then the <option> I have configured should be set to "<value>"

    Examples:
      | option          | value                   | type    |
      | api_key         | ANOTHERAPIKEY           | string  |
      | base_uri        | http://base.example.com | string  |
      | timeout         | 20                      | int     |
      | connect_timeout | 10                      | int     |
      | capacity        | 800                     | int     |
      | events          | true                    | boolean |