## Category Api

### `GET` Categories
```
/api/categories
```
Get list all categories with paginate
#### Request Headers
| Key | Value |
|---|---|
|Accept|application\json

#### Response
```json
{
    "data": [
        {
            "id": 1,
            "name": "Adelle Kiehn",
            "books_count": 3
        },
        {
            "id": 2,
            "name": "Prof. Ollie Wilderman Sr.",
            "books_count": 1
        },
        {
            "id": 3,
            "name": "Dariana Block",
            "books_count": 2
        },
        {
            "id": 4,
            "name": "Walter Collins",
            "books_count": 1
        },
        {
            "id": 5,
            "name": "Mr. Cecil Grant DVM",
            "books_count": 2
        },
        {
            "id": 6,
            "name": "Buck Reilly",
            "books_count": 0
        },
        {
            "id": 7,
            "name": "Prof. Eve Anderson",
            "books_count": 3
        },
        {
            "id": 8,
            "name": "Mr. Kevin Hand Sr.",
            "books_count": 2
        },
        {
            "id": 9,
            "name": "Stephania Ondricka",
            "books_count": 0
        },
        {
            "id": 10,
            "name": "Georgiana Harvey",
            "books_count": 1
        }
    ],
    "current_page": 1,
    "first_page_url": "http://library.devp/api/categories?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http://library.devp/api/categories?page=1",
    "next_page_url": null,
    "path": "http://library.devp/api/categories",
    "per_page": 10,
    "prev_page_url": null,
    "to": 10,
    "total": 10,
    "meta": {
        "message": "successfully",
        "code": 200
    }
}
```
