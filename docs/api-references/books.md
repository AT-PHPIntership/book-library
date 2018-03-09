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
        "message" : null,
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
        "message" : null,
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

### `GET` Search book with keyword.
```
    .../api/books?search=Mueller
```
    Get list book with correct keyword.

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
            "message": null,
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
        "message" : null,
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
        "message": null,
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

### `GET` Get book reviews
```
/api/books/{id}/reviews
```
Get book reviews
#### Request Headers
| Key | Value |
|---|---|
|Accept|application\json|
|Content-Type|application\json|

#### Parameters
| Key | Type | Required | Description |
|---|---|---|---|
| id | Integer | required | Book's id |

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
            "id": 1,
            "content": "Example content",
            "type": 1,
            "name": "Book's name",
            "team": "SA",
            "rating": 2,
            "created_at": "2018-03-01 07:36:37",
            "favorites_count": 1,
            "comments_count": 0
        },
        {
            "id": 2,
            "content": "Example content",
            "type": 1,
            "name": "Book's name",
            "team": "PHP",
            "rating": 2,
            "created_at": "2018-03-01 07:36:37",
            "favorites_count": 0,
            "comments_count": 0
        },
    ],
    "first_page_url": "http://booklibrary.test/api/books/2/reviews?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http://booklibrary.test/api/books/2/reviews?page=1",
    "next_page_url": null,
    "path": "http://booklibrary.test/api/books/2/reviews",
    "per_page": 20,
    "prev_page_url": null,
    "to": 2,
    "total": 2
}
```
### `GET` Filter book with keyword.
#### If exist category_id
```
    .../api/books?category=1
```
    Get list book with correct keyword.

### Request header
| Key | Value |
|---|---|
| Accept | application/json |
| Content-type | application/json |

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
            "id": 13,
            "name": "Casimer Toy PhD",
            "author": "Ms. Samanta Wisoky",
            "image": "http://book.library.org/storage//tmp/ad301391e0a025d2ed85209da512041a.jpg",
            "avg_rating": 3
        },
        {
            "id": 1,
            "name": "Valentin Stracke",
            "author": "Ms. Jane Bechtelar II",
            "image": "http://book.library.org/storage//tmp/0848a3ad0e513f44cd8ff82d0e378ced.jpg",
            "avg_rating": 1
        }
    ],
    "first_page_url": "http://book.library.org/api/books?category=1&page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http://book.library.org/api/books?category=1&page=1",
    "next_page_url": null,
    "path": "http://book.library.org/api/books",
    "per_page": 20,
    "prev_page_url": null,
    "to": 2,
    "total": 2
}
```
#### If don't exist category_id
```
    .../api/books?category=100
```
    Get list book with correct keyword.

### Request header
| Key | Value |
|---|---|
| Accept | application/json |
| Content-type | application/json |

### Response
```json
{
    "meta": {
        "message": null,
        "code": 200
    },
    "current_page": 1,
    "data": [],
    "first_page_url": "http://book.library.org/api/books?category=100&page=1",
    "from": null,
    "last_page": 1,
    "last_page_url": "http://book.library.org/api/books?category=100&page=1",
    "next_page_url": null,
    "path": "http://book.library.org/api/books",
    "per_page": 20,
    "prev_page_url": null,
    "to": null,
    "total": 0
}
```
#### If exist language
```
    .../api/books?language=ne
```
    Get list book with correct keyword.

### Request header
| Key | Value |
|---|---|
| Accept | application/json |
| Content-type | application/json |

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
            "id": 15,
            "name": "Mrs. Bonita Halvorson",
            "author": "Carolanne Gerhold",
            "image": "http://book.library.org/storage//tmp/3e0d81f3c9c9ec5b64ee681e917ef52c.jpg",
            "avg_rating": 4
        },
        {
            "id": 8,
            "name": "Kurtis Kunze",
            "author": "Shad Reichel",
            "image": "http://book.library.org/storage//tmp/cbefc5d6fd45890250cf674412bb219c.jpg",
            "avg_rating": 5
        }
    ],
    "first_page_url": "http://book.library.org/api/books?language=ne&page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http://book.library.org/api/books?language=ne&page=1",
    "next_page_url": null,
    "path": "http://book.library.org/api/books",
    "per_page": 20,
    "prev_page_url": null,
    "to": 2,
    "total": 2
}
```
#### If don't exist language
```
    .../api/books?language=pm
```
    Get list book with correct keyword.

### Request header
| Key | Value |
|---|---|
| Accept | application/json |
| Content-type | application/json |

### Response
```json
{
    "meta": {
        "message": null,
        "code": 200
    },
    "current_page": 1,
    "data": [],
    "first_page_url": "http://book.library.org/api/books?language=pm&page=1",
    "from": null,
    "last_page": 1,
    "last_page_url": "http://book.library.org/api/books?language=pm&page=1",
    "next_page_url": null,
    "path": "http://book.library.org/api/books",
    "per_page": 20,
    "prev_page_url": null,
    "to": null,
    "total": 0
}
```
#### If transfer 3 param category, search, language
```
    .../api/books?category=1&language=rm&search=a
```
    Get list book with correct keyword.

### Request header
| Key | Value |
|---|---|
| Accept | application/json |
| Content-type | application/json |

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
            "id": 1,
            "name": "Valentin Stracke",
            "author": "Ms. Jane Bechtelar II",
            "image": "http://book.library.org/storage//tmp/0848a3ad0e513f44cd8ff82d0e378ced.jpg",
            "avg_rating": 1
        }
    ],
    "first_page_url": "http://book.library.org/api/books?search=a&category=1&language=rm&page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http://book.library.org/api/books?search=a&category=1&language=rm&page=1",
    "next_page_url": null,
    "path": "http://book.library.org/api/books",
    "per_page": 20,
    "prev_page_url": null,
    "to": 1,
    "total": 1
}
```
