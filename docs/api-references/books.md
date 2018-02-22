## BOOK - API

### `GET` Book
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

## SEARCH BOOK WITH KEYWORD
```
    Return json data about search book by name or author.
```

**Search**
```
    .../api/books?search=keyword
```

**Search with keyword correct**
```
    .../api/books?search=Mueller
```

### Request header
| Key | Value |
|---|---|
| Accept | application/json |
| Content-type | application/json |

### Response
```json
    {
        "data": [
            {
                "id": 1,
                "name": "Aida II",
                "author": "Mueller",
                "image": "http://book.tech/storage/images/books/math.png",
                "avg_rating": 4
            },
            {
                "id": 2,
                "name": "Mueller Parker",
                "author": "Edison",
                "image": "http://book.tech/storage/images/books/math.png",
                "avg_rating": 5
            },
        ],
        "current_page": 1,
        "first_page_url": "http://library.devp/api/books?search=Mueller&page=1",
        "from": 1,
        "last_page": 1,
        "last_page_url": "http://library.devp/api/books?search=Mueller&page=1",
        "next_page_url": null,
        "path": "http://library.devp/api/books",
        "per_page": 10,
        "prev_page_url": null,
        "to": 1,
        "total": 2,
        "meta": {
            "message": "successfully",
            "code": 200
        }
    }
```

**Search with keyword incorrect**
```
    .../api/books?search=Laravel
```

### Request header
| Key | Value |
|---|---|
| Accept | application/json |
| Content-type | application/json |

### Response
```json
    {
        "data": [],
        "current_page": 1,
        "first_page_url": "http://library.devp/api/books?search=Mueller&page=1",
        "from": 0,
        "last_page": 1,
        "last_page_url": "http://library.devp/api/books?search=Mueller&page=1",
        "next_page_url": null,
        "path": "http://library.devp/api/books",
        "per_page": 10,
        "prev_page_url": null,
        "to": 0,
        "total": 0,
        "meta": {
            "message": "successfully",
            "code": 200
        }
    }
```

**Search with keyword is null**
```
    .../api/books?search=
```

### Request header
| Key | Value |
|---|---|
| Accept | application/json |
| Content-type | application/json |

### Response
```json
    {
        "data": [
            {
                "id": 1,
                "name": "Aida II",
                "author": "Roll",
                "image": "http://book.tech/storage/images/books/math.png",
                "avg_rating": 4
            },
            {
                "id": 2,
                "name": "Mueller Parker",
                "author": "Edison",
                "image": "http://book.tech/storage/images/books/math.png",
                "avg_rating": 3
            },
            {
                "id": 3,
                "name": "Mr. Arnoldo Cruickshank",
                "author": "Warren Medhurst",
                "image": "http://book.tech/storage/images/books/math.png",
                "avg_rating": 2
            },
            {
                "id": 4,
                "name": "Deion Ward",
                "author": "Edison",
                "image": "http://book.tech/storage/images/books/math.png",
                "avg_rating": 5
            },
            {
                "id": 5,
                "name": "Hudson",
                "author": "Edison",
                "image": "http://book.tech/storage/images/books/math.png",
                "avg_rating": 3
            },
            {
                "id": 6,
                "name": "Dr. Leonard Hickle III",
                "author": "Mauricio Hayes",
                "image": "http://book.tech/storage/images/books/math.png",
                "avg_rating": 2
            },
            {
                "id": 7,
                "name": "Mr. Simeon Brakus",
                "author": "Boyd Schulist",
                "image": "http://book.tech/storage/images/books/math.png",
                "avg_rating": 5
            },
            {
                "id": 8,
                "name": "Annette Rogahn Sr.",
                "author": "Koelpin",
                "image": "http://book.tech/storage/images/books/math.png",
                "avg_rating": 5
            },
            {
                "id": 9,
                "name": "Nichole McLaughlin",
                "author": "Ms. Lori Oberbrunner",
                "image": "http://book.tech/storage/images/books/math.png",
                "avg_rating": 3
            },
            {
                "id": 10,
                "name": "Kelli Weissnat Parker",
                "author": "Emanuel Rogahn",
                "image": "http://book.tech/storage/images/books/math.png",
                "avg_rating": 4
            }
        ],
        "current_page": 1,
        "first_page_url": "http://library.devp/api/books?search=Mueller&page=1",
        "from": 1,
        "last_page": 1,
        "last_page_url": "http://library.devp/api/books?search=Mueller&page=1",
        "next_page_url": null,
        "path": "http://library.devp/api/books",
        "per_page": 10,
        "prev_page_url": null,
        "to": 10,
        "total": 2,
        "meta": {
            "message": "successfully",
            "code": 200
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
        "status": "successfully",
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