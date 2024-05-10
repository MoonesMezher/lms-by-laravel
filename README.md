<h1>Library Management System (LMS)</h1>

- Postman test [documenter](https://documenter.getpostman.com/view/28836077/2sA3JM6gTo)
- Here are the instructions for setting up the project: <br/>
NOTE: you need to install xammp and any editor on your desktop.
<br>1- Clone the repository to your local machine using the following command: 
<br><code>git clone https://github.com/MoonesMezher/lms-by-laravel.git</code><br>
2- Navigate to the project directory: 
<br><code>cd lms-by-laravel</code><br>
3- Install the project dependencies using Composer: 
<br><code>composer install</code><br>
4- Create a copy of the .env.example file and rename it to .env: 
<br><code>cp .env.example .env</code><br>
5- Generate a new application key: 
<br><code>php artisan key:generate</code><br>
6- Configure the database connection in the .env file: 
<br><code>DB_CONNECTION=mysql<br>
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=laravel_example
        DB_USERNAME=root
        DB_PASSWORD=></code><br>
7- Run the database migrations: 
<br><code>php artisan migrate</code><br>
8- Seed the database with sample data (optional): 
<br><code>php artisan db:seed</code><br>
9- Start the development server: 
<br><code>php artisan serve</code><br>
10- Access the application in your web browser at http://localhost:8000. 

<h1>API Endpoints Overview</h1>

<h2>Users</h2>
POST /users/register: Register a new user.<br>
POST /users/login: Authenticate a user and return a token.<br>
GET /users/profile: Retrieve the profile of the currently authenticated user.<br>
PUT /users/profile: Update user profile details.<br>
<h2>Books</h2>
POST /books: Add a new book (admin only).<br>
GET /books: List all books, with optional filters for genre, author, and availability.<br>
GET /books/{id}: Get detailed information about a specific book.<br>
PUT /books/{id}: Update book information (admin only).<br>
DELETE /books/{id}: Remove a book from the library (admin only).<br>
<h2>Authors</h2>
POST /authors: Add a new author (admin only).<br>
GET /authors: List all authors.<br>
GET /authors/{id}: Get detailed information about a specific author.<br>
PUT /authors/{id}: Update author information (admin only).<br>
DELETE /authors/{id}: Delete an author (admin only).<br>
<h2>Reviews (Using Morph Relationships)</h2>
POST /reviews/books/{book_id}: Add a review to a book.<br>
POST /reviews/authors/{author_id}: Add a review to an author.<br>
GET /reviews: List all reviews for books and authors.<br>
PUT /reviews/{id}: Update a review (original reviewer only).<br>
DELETE /reviews/{id}: Delete a review (original reviewer or admin only).<br>
<h2>Notifications (Managed through Queue)</h2>
GET /notifications: List all notifications for the logged-in user.<br>
PUT /notifications/{id}/read: Mark a notification as read.<br>
