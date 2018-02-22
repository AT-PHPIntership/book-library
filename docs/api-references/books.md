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
        "status" : "successfully",
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

### `GET` Book Detail
```
/api/books/{id}
```
Get the book's information
#### Request Headers
| Key | Value |
|---|---|
|Accept|application\json
#### Response
```json
{
    "meta": {
        "status" : "successfully",
        "code" : 200,
    },
    "data": [
        {
            "name": "HTML & CSS",
            "author": "NagaSiro",
            "year": 2015,
            "page number": 275,
            "price": 200,
            "image": "http://library.at/books/images/image.png",
            "description": "Good or bad",
            "review_score": 4
        }
    ]
}
```