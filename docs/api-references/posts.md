## Post API

### `Post` Add Post
```
/api/post/{$type}/{$book_id}
```
Add new post.
#### Request body
| Key | Value |
|---|---|
| content | Content |
| image | file |

#### Description
| Key | Value |
|---|---|
| type | Required, Allow value: 1, 2, 3 |
| book_id | Integer |
| content | Required, text |
| image | file |

#### Sample Response
```json
{
  "meta": {
    "success": true,
    "code": 201
  },
  "data": {
    "id": 38,
    "user_id": 54,
    "book_id": 24,
    "type": 1,
    "content": "Voluptas",
    "image": null,
    "created_at": "2018-01-25 11:47:38",
    "updated_at": "2018-01-25 11:47:38",
    "deleted_at": null
  }
}
```
### `GET` List all posts of user with fitler is all
```
/api/users/{id}
```
Get list of status of user with paginate
#### Request Headers
| Key | Value |
|---|---|
|Accept|application\json
|Authorization|{token_type} {access_token}|

#### Parameters
| Key | Type | Required | Description |
|---|---|---|---|
| id | Integer | required | Id of user |

#### Response 
```json
{
    "meta": {
        "message": "successfully",
        "code": 200
    },
    "data": [
        {
            "id": 1,
            "user_id":1,  
            "name": "Tam Nguyen T.",          
            "content": "Et excepturi ipsa iusto repellat molestiae",
            "type": 1,
            "name": "Molestiae",
            "images": "http://book.tech/storage/images/books/book.png",
            "rating": 4.0,
            "like": 1,
            "created_at": "2018-02-26 03:23:09",
            "updated_at": "2018-02-26 03:23:09",
        }
        {
            "id": 2,
            "user_id":1,  
            "name": "Tam Nguyen T.",          
            "content": "Porro saepe sit dolorem aut",
            "type": 2,
            "name": null,
            "images": null,
            "rating": null,
            "like": 12,
            "created_at": "2018-02-26 03:23:09",
            "updated_at": "2018-02-26 03:23:09",
        }
        {
            "id": 3,
            "user_id":1,  
            "name": "Tam Nguyen T.",          
            "content": "Ut maiores quia nobis quam aliquid aut",
            "type": 3,
            "name": null,
            "images": null,
            "rating": null,
            "like": 12,
            "created_at": "2018-02-26 03:23:09",
            "updated_at": "2018-02-26 03:23:09",
        }
    ],
    "first_page_url": "http://book.tech/api/users/1?page=1",
    "from": 20,
    "last_page": 2,
    "last_page_url": "http://book.tech/api/users/1?page=2",
    "next_page_url": "http://book.tech/api/users/1?page=2",
    "path": "http://book.tech/api/users/1",
    "per_page": 20,
    "prev_page_url": null,
    "to": 1,
    "total": 21
}
```
#### Response - Fail
```json
{
    "meta": {
        "message": "Failed",
        "code": 404,
    },
    "error": {
        "message": "Data not found!",
    }
}
```
### `GET` List all posts of user with fitler is review
```
/api/users/{id}?type=1
```
Get list of status of user with paginate
#### Request Headers
| Key | Value |
|---|---|
|Accept|application\json
|Authorization|{token_type} {access_token}|

#### Parameters
| Key | Type | Required | Description |
|---|---|---|---|
| id | Integer | required | Id of user |
| type | Integer | required | Type of post |

#### Response - Success
```json
{
    "meta": {
        "message": "successfully",
        "code": 200
    },
    "data": [
        {
            "id": 1,
            "user_id":1,  
            "name": "Tam Nguyen T.",          
            "content": "Et excepturi ipsa iusto repellat molestiae",
            "type": 1,
            "name": "Molestiae",
            "images": "http://book.tech/storage/images/books/book.png",
            "rating": 5.0,
            "like": 12,
            "created_at": "2018-02-26 03:23:09",
            "updated_at": "2018-02-26 03:23:09",
        }
        {
            "id": 2,
            "user_id":1,  
            "name": "Tam Nguyen T.",          
            "content": "Et excepturi ipsa iusto repellat molestiae",
            "type": 1,
            "name": "Molestiae",
            "images": "http://book.tech/storage/images/books/book.png",
            "rating": 4.0,
            "like": 1,
            "created_at": "2018-02-26 03:23:09",
            "updated_at": "2018-02-26 03:23:09",
        }
    ],
    "first_page_url": "http://book.tech/api/users/1?type=1&page=1",
    "from": 20,
    "last_page": 2,
    "last_page_url": "http://book.tech/api/users/1?type=1&page=2",
    "next_page_url": "http://book.tech/api/users/1?type=1&page=2",
    "path": "http://book.tech/api/users/1?type=1",
    "per_page": 20,
    "prev_page_url": null,
    "to": 1,
    "total": 21
}
```

### `GET` List all posts of user with fitler is status
```
/api/users/{id}?type=2
```
Get list of status of user with paginate
#### Request Headers
| Key | Value |
|---|---|
|Accept|application\json
|Authorization|{token_type} {access_token}|

#### Parameters
| Key | Type | Required | Description |
|---|---|---|---|
| id | Integer | required | Id of user |
| type | Integer | required | Type of post |

#### Response - Success
```json
{
    "meta": {
        "message": "successfully",
        "code": 200
    },
    "data": [
        {
            "id": 1,
            "user_id":1,  
            "name": "Tam Nguyen T.",          
            "content": "Et excepturi ipsa iusto repellat molestiae",
            "type": 2,
            "name": null,
            "images": null,
            "rating": null,
            "like": 12,
            "created_at": "2018-02-26 03:23:09",
            "updated_at": "2018-02-26 03:23:09",
        }
        {
            "id": 2,
            "user_id":1,  
            "name": "Tam Nguyen T.",          
            "content": "Et excepturi ipsa iusto repellat molestiae",
            "type": 2,
            "name": null,
            "images": null,
            "rating": null,
            "like": 1,
            "created_at": "2018-02-26 03:23:09",
            "updated_at": "2018-02-26 03:23:09",
        }
    ],
    "first_page_url": "http://book.tech/api/users/1?type=2&page=1",
    "from": 20,
    "last_page": 2,
    "last_page_url": "http://book.tech/api/users/1?type=2&page=2",
    "next_page_url": "http://book.tech/api/users/1?type=2&page=2",
    "path": "http://book.tech/api/users/1?type=2",
    "per_page": 20,
    "prev_page_url": null,
    "to": 1,
    "total": 21
}
```

### `GET` List all posts of user with fitler is find book
```
/api/users/{id}?type=3
```
Get list of status of user with paginate
#### Request Headers
| Key | Value |
|---|---|
|Accept|application\json
|Authorization|{token_type} {access_token}|

#### Parameters
| Key | Type | Required | Description |
|---|---|---|---|
| id | Integer | required | Id of user |
| type | Integer | required | Type of post |

#### Response - Success
```json
{
    "meta": {
        "message": "successfully",
        "code": 200
    },
    "data": [
        {
            "id": 1,
            "user_id":1,  
            "name": "Tam Nguyen T.",          
            "content": "Et excepturi ipsa iusto repellat molestiae",
            "type": 2,
            "name": null,
            "images": null,
            "rating": null,
            "like": 12,
            "created_at": "2018-02-26 03:23:09",
            "updated_at": "2018-02-26 03:23:09",
        }
        {
            "id": 2,
            "user_id":1,  
            "name": "Tam Nguyen T.",          
            "content": "Et excepturi ipsa iusto repellat molestiae",
            "type": 2,
            "name": null,
            "images": null,
            "rating": null,
            "like": 1,
            "created_at": "2018-02-26 03:23:09",
            "updated_at": "2018-02-26 03:23:09",
        }
    ],
    "first_page_url": "http://book.tech/api/users/1?type=3&page=1",
    "from": 20,
    "last_page": 2,
    "last_page_url": "http://book.tech/api/users/1?type=3&page=2",
    "next_page_url": "http://book.tech/api/users/1?type=3&page=2",
    "path": "http://book.tech/api/users/1?type=3",
    "per_page": 20,
    "prev_page_url": null,
    "to": 1,
    "total": 21
}
```
