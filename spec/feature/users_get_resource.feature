Feature: GET /users/<id>
    As a booothy user
    In order to check whether I'm an allowed user
    I need to check my existence in the platform

    Scenario: getting an allowed user
        Given the list with the allowed users:
            | id                   |
            | monesvol@example.com |
        When I send a GET request to /api/users/monesvol@example.com
        Then I should obtain a 200 status code
        And the response should be
            """
                {
                    "id"     : "monesvol@example.com",
                    "avatar" : "//www.gravatar.com/avatar/f639ef5d92886bf898c315c8cc544571"
                }
            """
