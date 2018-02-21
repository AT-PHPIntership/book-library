## BOOK - API

### `GET` List book
```
/api/books
```
Get list books with paginate

#### Request Headers
| Key | Value |
|---|---|
|Accept|application\json

#### Request Body
| Key | Value |
|---|---|
| content | Content |

#### Response
```json
{
    "meta": {
        "status" : "success",
        "code" : 200,
    },
    "data": [
        {
            "id": 1,
            "name": "Aida Bode II",
            "image": "http://book.tech/storage/images/books/math.png",
            "avg_rating": 4 
        },
        {
            "id": 2,
            "name": "Leonor Parker",
            "image": "http://book.tech/storage/images/books/math.png",
            "avg_rating": 5
        },
    ],
    "paginate": {
        "total": 30,
        "count": 20,
        "per_page": 20,
        "current_page": 1,
        "total_pages": 2,
        "links": {
            "next": "http://book.tech/api/books?page=2"
        }
    }
}
```
