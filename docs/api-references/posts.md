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

### `GET` List all posts of user with type post
```
/api/users/{id}/posts?type=1
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
| type | Integer | required | Type of post (1: review book, 2: status, 3: find book) |

#### Response
```json
{
    "meta": {
        "message": "null",
        "code": 200
    },
    "data": [
        {
            "id": 1,
            "user_name": "Tam Nguyen T.",          
            "content": "Et excepturi ipsa iusto repellat molestiae",
            "type": 1,
            "book_name": "Molestiae",
            "image": "http://book.tech/storage/images/books/book.png",
            "avg_rating": 4.0,
            "created_at": "2018-02-26 03:23:09",
            "updated_at": "2018-02-26 03:23:09",
            "comments_count": 1,
            "favorites_count": 2
        },
        {
            "id": 2,
            "user_name": "Tam Nguyen T.",          
            "content": "Porro saepe sit dolorem aut",
            "type": 2,
            "book_name": null,
            "image": null,
            "avg_rating": null,
            "created_at": "2018-02-26 03:23:09",
            "updated_at": "2018-02-26 03:23:09",
            "comments_count": 1,
            "favorites_count": 2
        },
        {
            "id": 3,
            "user_name": "Tam Nguyen T.",          
            "content": "Porro saepe sit dolorem aut",
            "type": 3,
            "book_name": null,
            "image": null,
            "avg_rating": null,
            "created_at": "2018-02-26 03:23:09",
            "updated_at": "2018-02-26 03:23:09",
            "comments_count": 1,
            "favorites_count": 2
        }
    ],
    "first_page_url": "http://book.tech/api/users/1/posts?page=1",
    "from": 20,
    "last_page": 2,
    "last_page_url": "http://book.tech/api/users/1/posts?page=2",
    "next_page_url": "http://book.tech/api/users/1/posts?page=2",
    "path": "http://book.tech/api/users/1/posts",
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
        "message": "User not found",
        "code": 404,
    }
}
```
