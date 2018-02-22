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
        "message" : "successfully",
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
        "total": 30,
        "count": 20,
        "per_page": 20,
        "current_page": 1,
        "total_pages": 2,
        "links": {
            "next": "http://book.tech/api/books?page=2"
        }
}

```
### `GET` Top books borrow
```
/api/books/borrow/top
```
Get top books borrow

#### Request Body
| Key | Value |
|---|---|
| content | Content |


#### Response
```json
{
    "meta": {
        "message" : "successfully",
        "code" : 200,
    },
    "data" : [
        {
            "id": 1,
            "name": "Aida Bode II",
            "image": "http://book.tech/storage/images/books/math.png",
            "avg_rating": 1.0,
        },
        {
            "id": 2,
            "name": "Aida Bode II",
            "image": "http://book.tech/storage/images/books/math.png",
            "avg_rating": 2.0,
        },
        {
            "id": 3,
            "name": "Aida Bode II",
            "image": "http://book.tech/storage/images/books/math.png",
            "avg_rating": 3.0,
        },
    ],
    "current_page": 1,
    "first_page_url": "http://library.devp/api/books/borrow/top?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http://library.devp/api/books/borrow/top?page=1",
    "next_page_url": null,
    "path": "http://library.devp/api/books/borrow/top",
    "per_page": 20,
    "prev_page_url": null,
    "to": 20,
    "total": 20,
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
        "message" : "successfully",
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
