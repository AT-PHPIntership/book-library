## Book API

### `POST` Add Comment
```
/api/post/{{ $id }}/comment

 ```
 Add comments under book detail in detail page.
#### Request header
| Key | Value |
|---|---|
| Authorization | {token_type} {access_token} |

#### Request body
| Key | Value |
|---|---|
| content | Content |
| parent_id | 1 |

#### Sample Response
```json
{
 "meta": {
    "success": true,
    "code": 201
  },
  "data": {
    "id": 2,
    "post_id": 9,
    "user_id": 5,
    "content": "Recusandae",
    "parent_id": 3,
    "created_at": "2018-01-25 11:43:09",
    "updated_at": "2018-01-25 11:43:09",
    "deleted_at": null
  }
}
```

### `Post` Add Post
```
/api/post/{$type}/{$book_id}
```
Add add new review under book detail in detail page.
#### Request body
| Key | Value |
|---|---|
| content | Content |
| image | file |

#### Sample Response
```json
{
  "meta": {
    "success": true,
    "status_code": 201
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