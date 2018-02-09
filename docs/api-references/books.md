## Book Api

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