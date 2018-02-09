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
        "id": 18,
        "employee_code": "AT0123",
        "name": "An Nguyen Q.",
        "email": "an.nguyen@gmail.com.vn",
        "team": "PHP",
        "avatar_url": "http://172.16.110.17/images/user/avatar/350/40c1fc7286.png",
        "role": 1,
        "access_token": "40604dab9b3c87be058a3096d4f4f5e8",
        "expired_at": "2018-02-09 05:38:13",
        "created_at": "2018-02-01 07:51:59",
        "updated_at": "2018-02-09 03:37:16",
        "deleted_at": null
    }
}
```
#### Sample Request body
##### Password is empty
```json
{
  "email": "an.nguyen@gmail.com",
  "password": "",
}
```

```json
{
    "meta": {
        "status": "failed",
        "code": 400,
        "messages": "email_or_password_cannot_blank"
    },
    "error": "Email or Password cannot blank"
}
```
#### Sample Request body
##### Failure password 
```json
{
  "email": "an.nguyen@gmail.com",
  "password": "abc",
}
```
```json
{
    "meta": {
        "status": "failed",
        "code": 400,
        "messages": "email_or_password_not_correct"
    },
    "error": "Email or password not correct"
}
```
