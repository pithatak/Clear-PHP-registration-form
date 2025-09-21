# Test Project

This is a simple PHP project using MySQL.

## Setup

1. **Install MySQL** and create the database:

CREATE DATABASE test_project CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

2. Create tables:

CREATE TABLE users (
   id INT AUTO_INCREMENT PRIMARY KEY,
   first_name VARCHAR(50) NOT NULL,
   last_name VARCHAR(50) NOT NULL,
   email VARCHAR(100) UNIQUE NOT NULL,
   phone VARCHAR(20),
   password VARCHAR(255) NOT NULL
);

3. Start the project locally:

php -S localhost:8000

4. Open your browser and go to http://localhost:8000

