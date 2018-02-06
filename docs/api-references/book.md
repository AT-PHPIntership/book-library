## BOOK - API

### `GET` List New Book
```
api/books
```
List top 20 new books
#### Request header
| Key | Value |
|---|---|
| Accept | application/json |
| Content-type | application/json |
#### Sample Request
```
GET: api/books
```
#### Sample Response
```json
{
    "books": {
        "current_page": 1,
        "data": [
            {
                "id": 11,
                "name": "Zackery Kovacek",
                "image": "/tmp/5ec489747324c7ce7d710ceb19ee8fd9.jpg",
                "avg_rating": 4
            },
            {
                "id": 8,
                "name": "Dr. Arvid Pacocha V",
                "image": "/tmp/3e955563398dcc1b035e61396d7faa51.jpg",
                "avg_rating": 1
            },
            {
                "id": 16,
                "name": "Charley Stokes",
                "image": "/tmp/d99c3fa0f3162334d60cde9832b1b45d.jpg",
                "avg_rating": 4
            },
            {
                "id": 15,
                "name": "Maximus Lindgren",
                "image": "/tmp/07e0e4c48cb0cc12b96daf3b35b46a2a.jpg",
                "avg_rating": 3
            },
            {
                "id": 14,
                "name": "Waino Klein",
                "image": "/tmp/f97b70270217e4db5bd0a0e488f27b96.jpg",
                "avg_rating": 4
            },
            {
                "id": 13,
                "name": "Orin Goldner",
                "image": "/tmp/cf45f3f0bf82c2839a92a55b18168aee.jpg",
                "avg_rating": 2
            },
            {
                "id": 12,
                "name": "Dr. Dan McCullough II",
                "image": "/tmp/ac781b049d9d30aebbd3355e44556dd0.jpg",
                "avg_rating": 5
            },
            {
                "id": 10,
                "name": "Sigurd Altenwerth",
                "image": "/tmp/a236d4e6f85870ed1305ace1650d84cf.jpg",
                "avg_rating": 2
            },
            {
                "id": 9,
                "name": "Katrina Ortiz Jr.",
                "image": "/tmp/f43fd4a1f003894c70291966aaa48aa9.jpg",
                "avg_rating": 5
            },
            {
                "id": 7,
                "name": "Miss Nyah Raynor",
                "image": "/tmp/a0b5645cab70fe067345294f1c1a2ae6.jpg",
                "avg_rating": 5
            },
            {
                "id": 6,
                "name": "Glen Lubowitz",
                "image": "/tmp/de618bea5bab4e9c72e95e62c7bb229b.jpg",
                "avg_rating": 2
            },
            {
                "id": 5,
                "name": "Mr. Stanley Rippin",
                "image": "/tmp/7b26b0bc653f447013317fe7ddde4a7b.jpg",
                "avg_rating": 2
            },
            {
                "id": 4,
                "name": "Madilyn Schaefer",
                "image": "/tmp/2814d1954d29fbbbc3a04e362248422d.jpg",
                "avg_rating": 3
            },
            {
                "id": 3,
                "name": "Broderick Renner",
                "image": "/tmp/3bb6d221bb2537fa69bc6794333603d6.jpg",
                "avg_rating": 5
            },
            {
                "id": 2,
                "name": "Jaleel Fadel",
                "image": "/tmp/0cd0c1816a884b3c909e87feb93377e7.jpg",
                "avg_rating": 5
            },
            {
                "id": 1,
                "name": "Alphonso Kessler",
                "image": "/tmp/cda83e2a013ec92950b5ed471ddabcc0.jpg",
                "avg_rating": 5
            }
        ],
        "first_page_url": "http://book.tech/api/books?page=1",
        "from": 1,
        "last_page": 1,
        "last_page_url": "http://book.tech/api/books?page=1",
        "next_page_url": null,
        "path": "http://book.tech/api/books",
        "per_page": 20,
        "prev_page_url": null,
        "to": 16,
        "total": 16
    },
    "success": true
}
```
