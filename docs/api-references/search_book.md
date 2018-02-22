## Book Api

## SEARCH BOOK WITH KEYWORD
```
    Return json data about search book by name, author or description
```
----
**Search**
```
    .../api/books?search=keyword
```
----
**Search with keyword correct**
- The response will have data
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
        "books": {
            "data": [
                {
                    "id": 15,
                    "name": "Brady Mueller",
                    "image": "/tmp/942826e237ed0b320f679e8c5c57fe6a.jpg",
                    "avg_rating": 2
                }
            ],
        },
        "success": true
        }
    }
```
----
**Search with keyword incorrect**
```
    .../api/books?search=DamVinhHung
```
- The query of search with keyword is DamVinhHung
### Request header
| Key | Value |
|---|---|
| Accept | application/json |
| Content-type | application/json |
### Response
```json
    {
        "books": {
            "data": [],
        },
        "success": true
    }
```
----
**Search with keyword is null**
```
    .../api/books?search=
```
- The query of search with keyword is null

### Request header
| Key | Value |
|---|---|
| Accept | application/json |
| Content-type | application/json |
### Response
```json
    {
        "books": {
            "data": [
                {
                    "id": 17,
                    "name": "asgsagdsagasdgsda",
                    "image": "images/books/default//no-image.png",
                    "avg_rating": 0
                },
                {
                    "id": 16,
                    "name": "Marlon Kuhn III",
                    "image": "/tmp/e88304f905de83e6ea0fa3ebaebd7d17.jpg",
                    "avg_rating": 3
                },
                {
                    "id": 15,
                    "name": "Brady Mueller",
                    "image": "/tmp/942826e237ed0b320f679e8c5c57fe6a.jpg",
                    "avg_rating": 2
                },
                {
                    "id": 14,
                    "name": "Oma Brown",
                    "image": "/tmp/a312914feea7c16804fc55193b3c7eff.jpg",
                    "avg_rating": 1
                },
                {
                    "id": 13,
                    "name": "Ms. Astrid Dickens",
                    "image": "/tmp/34408f2f65d975b4b217419d1470b093.jpg",
                    "avg_rating": 1
                },
                {
                    "id": 12,
                    "name": "Margaretta Jacobs",
                    "image": "/tmp/b6adbeea676480a29e8b580bbc050abe.jpg",
                    "avg_rating": 2
                },
                {
                    "id": 11,
                    "name": "Jane West",
                    "image": "/tmp/37a84473b6d646b5edef1c06ac6e969c.jpg",
                    "avg_rating": 2
                },
                {
                    "id": 10,
                    "name": "Liza Von",
                    "image": "/tmp/b81d2cf7fb42fda689897d44af382431.jpg",
                    "avg_rating": 3
                },
                {
                    "id": 9,
                    "name": "Rowland Nikolaus II",
                    "image": "/tmp/904c63b1fd9e44f6cbbf197df137ad37.jpg",
                    "avg_rating": 4
                },
                {
                    "id": 8,
                    "name": "Leslie Franecki",
                    "image": "/tmp/dd90b1e15cdda49ce99a9d3bb2e7931e.jpg",
                    "avg_rating": 2
                },
                {
                    "id": 7,
                    "name": "Adolfo Green PhD",
                    "image": "/tmp/463d1494b754440469b0e23f5e20e216.jpg",
                    "avg_rating": 5
                },
                {
                    "id": 6,
                    "name": "Prof. Guillermo Gerhold PhD",
                    "image": "/tmp/058eafcba63846cc77f678f6c9639c9e.jpg",
                    "avg_rating": 5
                },
                {
                    "id": 5,
                    "name": "Elisabeth Mertz V",
                    "image": "/tmp/86a898c4a2eb59e5b8208531c0433daf.jpg",
                    "avg_rating": 4
                },
                {
                    "id": 4,
                    "name": "Prof. Milan Schmitt",
                    "image": "/tmp/03f9bdf47a23cef2ad51472859b9092b.jpg",
                    "avg_rating": 2
                },
                {
                    "id": 3,
                    "name": "Ms. Wava Lehner I",
                    "image": "/tmp/9d5e86aaee1bc43a10fd06600ab06958.jpg",
                    "avg_rating": 1
                },
                {
                    "id": 2,
                    "name": "Marge Rempel IV",
                    "image": "/tmp/688c4f4b803c24f707919a02aa45c67f.jpg",
                    "avg_rating": 2
                },
                {
                    "id": 1,
                    "name": "Reece Kassulke",
                    "image": "/tmp/55cbc340f08a656e692a307b1bc6ac04.jpg",
                    "avg_rating": 1
                }
            ],
        },
        "success": true
        }
    }
```
