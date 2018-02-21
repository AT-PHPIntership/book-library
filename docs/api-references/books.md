## Book Api

### `GET` Top 10 book review
```
/api/books/topReview
```
Get top 10 book review
#### Request Headers
| Key | Value |
|---|---|
|Accept|application\json

### Response
```json
{
    "meta": {
        "message": "Successfully",
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