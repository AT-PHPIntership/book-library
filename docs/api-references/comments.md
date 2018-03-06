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
    "id": 2,
    "user_id": 5,
    "content": "new comment",
  }
}
```
