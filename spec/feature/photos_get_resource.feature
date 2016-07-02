Feature: GET /photos/<id>
    As a booothy user
    In order to speed up the loading
    I need to be able to load a single photo


    Scenario: getting a detailed photo
        Given an allowed user
        And the list of the existing photos:
            | id | quote    | upload_filename | upload_mime_type | upload_provider | image_hex_color | image_width | image_height | creation_date       | user_id              |
            | 01 | quote 01 | quote_01.png    | image/png        | booothy         | #f3f3f3         | 640         | 480          | 1991-04-12 00:12:00 | monesvol@example.com |
        When I send a GET request to '/api/photos/01' with a token
        Then I should obtain a 200 status code
        And the response should be
            """
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
            }
            """


    Scenario: trying to load a non existing photo
        Given an allowed user
        And the list of the existing photos:
            | id | quote    | upload_filename | upload_mime_type | upload_provider | image_hex_color | image_width | image_height | creation_date       | user_id              |
            | 01 | quote 01 | quote_01.png    | image/png        | booothy         | #f3f3f3         | 640         | 480          | 1991-04-12 00:12:00 | monesvol@example.com |
        When I send a GET request to '/api/photos/02' with a token
        Then I should obtain a 404 status code
        And the response should be
            """
            {
                "error" : "Non existing boooth 02"
            }
            """
