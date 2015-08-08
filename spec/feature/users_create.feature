Feature: console booothy:create-user
    As a booothy administrator
    In order to allow the access to someone
    I need to be able to add a user using a console command


    Scenario: adding a new user
        When I execute the 'booothy:create-user' command with options:
            | option  | value                |
            | --email | monesvol@example.com |
        Then the command should exit with code 0
        And the user 'monesvol@example.com' should exist
