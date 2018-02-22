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
    "current_page": 1,
    "first_page_url": "http://library.devp/api/books?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http://library.devp/api/books?page=1",
    "next_page_url": null,
    "path": "http://library.devp/api/books",
    "per_page": 20,
    "prev_page_url": null,
    "to": 20,
    "total": 2,
}

```
### `GET` Top books borrow
```
/api/books/top-borrow
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
    "first_page_url": "http://library.devp/api/books/top-borrow?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http://library.devp/api/books/top-borrow?page=1",
    "next_page_url": null,
    "path": "http://library.devp/api/books/top-borrow",
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

### `GET` Top 10 book review
```
/api/books/top-review
```
Get top 10 book review
#### Request Headers
| Key | Value |
|---|---|
|Accept|application\json|
|Content-Type|application\json|

### Response
```json
{
    "meta": {
        "message": "successfully",
        "code": 200
    },
    "data": [
        {
            "name": "Aurora Briggs",
            "image": "booklibrary.test/images/books/default/no-image.png",
            "avg_rating": 0,
            "posts_count": 4
        },
        {
            "name": "10 điều khác biệt nhất giữa kẻ thắng và người thua",
            "image": "booklibrary.test/images/books/default/no-image.png",
            "avg_rating": 0,
            "posts_count": 3
        },
        {
            "name": "Những phương pháp hữu hiệu phòng chống stress",
            "image": "booklibrary.test/images/books/default/no-image.png",
            "avg_rating": 0,
            "posts_count": 3
        },
        {
            "name": "Nhà Giả Kim",
            "image": "booklibrary.test/images/books/default/no-image.png",
            "avg_rating": 0,
            "posts_count": 2
        },
        {
            "name": "Sức mạnh của toàn tâm toàn ý",
            "image": "booklibrary.test/images/books/default/no-image.png",
            "avg_rating": 0,
            "posts_count": 2
        },
        {
            "name": "10 điều khác biệt nhất giữa kẻ giàu và người nghèo",
            "image": "booklibrary.test/images/books/default/no-image.png",
            "avg_rating": 0,
            "posts_count": 2
        },
        {
            "name": "Bí quyết thuyết trình của Steven Jobs",
            "image": "booklibrary.test/images/books/default/no-image.png",
            "avg_rating": 0,
            "posts_count": 2
        },
        {
            "name": "Thiên tài gàn dở và câu chuyện thần kỳ về quả táo",
            "image": "booklibrary.test/images/books/default/no-image.png",
            "avg_rating": 0,
            "posts_count": 2
        },
        {
            "name": "Phát triển lòng tự tin và tạo ảnh hưởng bằng diễn thuyết",
            "image": "booklibrary.test/images/books/default/no-image.png",
            "avg_rating": 0,
            "posts_count": 2
        },
        {
            "name": "Luật trí não",
            "image": "booklibrary.test/images/books/default/no-image.png",
            "avg_rating": 0,
            "posts_count": 2
        }
    ]
}
```
