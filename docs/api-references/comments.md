## Comment API

### `POST` Add Comment
```
/api/post/{{ $id }}/comment

 ```
 Add comment for post.
#### Request body
| Key | Value |
|---|---|
| content | Content |
| parent_id | 1 |

#### Description
| Key | Value |
|---|---|
| id | Required interger |
| content | Required text |
| parent_id | Interger |

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
### `PUT` Update comments
```
/api/comments/{id}
```
Update the comment
#### Request Headers
| Key | Value |
|---|---|
|Accept|application\json
|Content-Type|application/json
|Authorization|{token_type} {access_token}|

#### Parameters
| Key | Type | Required | Description |
|---|---|---|---|
| content | String | required | content of comment |

#### Sample Request
```json
{
	"content": "new comment",
}
```

#### Response
```json
{
  "meta": {
    "success": true,
    "code": 200
  },
  "data": {
    "content": "new comment",
  }
}
```

### `GET` Get review comments
```
/api/posts/{id}/comments
```
Get review book comments
#### Request Headers
| Key | Value |
|---|---|
|Accept|application\json|
|Content-Type|application\json|

#### Parameters
| Key | Type | Required | Description |
|---|---|---|---|
| id | Integer | required | Post's id |

### Response
```json
{
    "meta": {
        "message": null,
        "code": 200
    },
    "current_page": 1,
    "data": [
        {
            "id": 2,
            "content": "This is comment",
            "created_at": "2018-03-01 07:36:37",
            "name": "My name is name",
            "team": "SA",
            "avatar_url": null
        },
        {
            "id": 3,
            "content": "This is comment",
            "created_at": "2018-03-01 07:36:37",
            "name": "My name is name",
            "team": "PHP",
            "avatar_url": null
        }
    ],
    "first_page_url": "http://booklibrary.test/api/posts/1/comments?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http://booklibrary.test/api/posts/1/comments?page=1",
    "next_page_url": null,
    "path": "http://booklibrary.test/api/posts/1/comments",
    "per_page": 10,
    "prev_page_url": null,
    "to": 7,
    "total": 7
}
```

### `DELETE` Delete Comment
```
/api/comments/{$id}

 ```
 Delete comment or subcomment.
#### Request body
| Key | Type | Required | Example|
|---|---|---|---|
| id | Integer | required | 1

#### Sample Response
```json
{
 "meta" : {
    "message" : "Delete Successful",
    "code" : 204
  }
}
```
```json
{
    "meta": {
        "message": "Must not Delete",
        "code": 401
    }
}
```
```json
{
    "meta": {
        "message": "Page Not Found",
        "code": 404
    }
}
```