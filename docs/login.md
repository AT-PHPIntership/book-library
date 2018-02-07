#Login API
### `POST` Login API from FE
```
api/login
```
Login by API
### Request header
|Key|Value|
|---|---|
| Accept | application/json |
| Authorization | {token_type} {access_token} |

#### Parameters
| Key | Type | Required | Description |
|---|---|---|---|
| email | String | required | email to login |
| password | String | required | password |

#### Sample Request body
```json
{
  "email": "an.nguyen@gmail.com",
  "password": "123456",
}
```
#### Sample Response
```json
{
    "meta": {
        "status": "successfully",
        "code": 200
    },
    "data": {
        "employee_code": "ATI0274",
        "probation": false,
        "id": 350,
        "first_login": false,
        "available_for_project_assignment": false,
        "name": "An Nguyen Q.",
        "has_line_member": false,
        "teams": [
            {
                "id": 22,
                "name": "PHP"
            }
        ],
        "projects": [],
        "employee_type": "Intern",
        "avatar_url": "http://172.16.110.17/images/user/avatar/350/40c1fc7286.png",
        "access_token": "be88e5d9c6b64fbe7e293e4ac9df9a1a",
        "expires_at": "2018-02-07 03:54:53 UTC",
        "joined_company_day": "2017-06-13"
    }
}
```

