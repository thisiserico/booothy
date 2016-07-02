Feature: GET /photos
    As a booothy user
    In order to scroll down the boooths list
    I need to load the complete list


    Scenario: getting the photo list
        Given an allowed user
        And the list of the existing photos:
            | id | quote    | upload_filename | upload_mime_type | upload_provider | image_hex_color | image_width | image_height | creation_date       | user_id              |
            | 01 | quote 01 | quote_01.png    | image/png        | booothy         | #f3f3f3         | 640         | 480          | 1991-04-12 00:12:00 | monesvol@example.com |
            | 02 | quote 02 | quote_02.png    | image/png        | booothy         | #f3f3f3         | 640         | 480          | 1991-04-12 00:12:00 | monesvol@example.com |
        When I send a GET request to '/api/photos' with a token
        Then I should obtain a 200 status code
        And the response should be
            """
            [
                {
                    "id"            : "01",
                    "quote"         : "quote 01",
                    "upload"        : {
                        "filename"           : "quote_01.png",
                        "mime_type"          : "image/png",
                        "download_url"       : "//booothy.dev/u/quote_01.png",
                        "thumb_download_url" : "//booothy.dev/u/thumb/quote_01.png"
                    },
                    "image_details" : {
                        "hex_color" : "#f3f3f3",
                        "width"     : "640",
                        "height"    : "480"
                    },
                    "creation_date" : "1991-04-12 00:12:00",
                    "user"          : "monesvol@example.com"
                },
                {
                    "id"            : "02",
                    "quote"         : "quote 02",
                    "upload"        : {
                        "filename"           : "quote_02.png",
                        "mime_type"          : "image/png",
                        "download_url"       : "//booothy.dev/u/quote_02.png",
                        "thumb_download_url" : "//booothy.dev/u/thumb/quote_02.png"
                    },
                    "image_details" : {
                        "hex_color" : "#f3f3f3",
                        "width"     : "640",
                        "height"    : "480"
                    },
                    "creation_date" : "1991-04-12 00:12:00",
                    "user"          : "monesvol@example.com"
                }
            ]
            """


    Scenario: getting a page with no photos
        Given an allowed user
        And the list of the existing photos:
            | id | quote    | upload_filename | upload_mime_type | upload_provider | image_hex_color | image_width | image_height | creation_date       | user_id              |
            | 01 | quote 01 | quote_01.png    | image/png        | booothy         | #f3f3f3         | 640         | 480          | 1991-04-12 00:12:00 | monesvol@example.com |
            | 02 | quote 02 | quote_02.png    | image/png        | booothy         | #f3f3f3         | 640         | 480          | 1991-04-12 00:12:00 | monesvol@example.com |
        When I send a GET request to '/api/photos' with parameters
            | attribute | value |
            | id_token  | 1234  |
            | page      | 2     |
        Then I should obtain a 200 status code
        And the response should be
            """
            []
            """
