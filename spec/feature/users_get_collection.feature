Feature: GET /users
    As a booothy user
    In order to be able to filter information per user
    I need to obtain all the allowed users


    Scenario: not being allowed to execute the request
        When I send a GET request to '/api/users'
        Then I should obtain a 403 status code
        And the response should be
            """
            {
                "message" : "Disallowed user"
            }
            """


    Scenario: invalid id_token
        When I send a GET request to '/api/users' with parameters
            | attribute | value |
            | id_token  | 12345 |
        Then I should obtain a 403 status code
        And the response should be
            """
            {
                "message" : "Disallowed user"
            }
            """


    Scenario: getting the complete list of allowed users
        Given the list with the allowed users:
            | id                   |
            | monesvol@example.com |
            | jhon.doe@example.com |
            | jane.doe@example.com |
        When I send a GET request to '/api/users' with parameters
            | attribute | value |
            | id_token  | 12345 |
        Then I should obtain a 200 status code
        And the response should be
            """
            [
                {
                    "id"     : "monesvol@example.com",
                    "avatar" : "//www.gravatar.com/avatar/f639ef5d92886bf898c315c8cc544571"
                },
                {
                    "id"     : "jhon.doe@example.com",
                    "avatar" : "//www.gravatar.com/avatar/e91e53c8cb9d2e0f5866eff5ac192e32"
                },
                {
                    "id"     : "jane.doe@example.com",
                    "avatar" : "//www.gravatar.com/avatar/0cba00ca3da1b283a57287bcceb17e35"
                }
            ]
            """
