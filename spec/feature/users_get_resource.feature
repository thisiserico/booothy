Feature: GET /users/<id>
    As a booothy user
    In order to check whether I'm an allowed user
    I need to check my existence in the platform

    Scenario: trying to get a disallowed user
        Given the list with the allowed users:
            | id                   |
            | monesvol@example.com |
        When I send a GET request to /api/users/monesvol@example.com
        Then I should obtain a 404 status code
        And the response should be
            """
                {
                    "_id" : "monesvol@example.com"
                }
            """
