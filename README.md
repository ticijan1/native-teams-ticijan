## This app relys on books from the isbn database

This application is a book management API. It integrates with the ISBN database to retrieve book details, including authors, publishers, and subjects. The app allows users to manage books, authors, publishers, and subjects efficiently, with features like:

- Adding and updating books fetched from ISBN and auto-filling data for associated authors, publishers, and subjects (the POST '/books' API will fill all of the tables with data from a single book search).
- Simple CRUD for authors.
- Ensuring data consistency with robust validation and error handling.
- Unit-tested services for reliable functionality (only one service test is included just to get an idea of how i write tests).
