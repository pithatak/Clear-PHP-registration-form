# 🧩 Clear PHP Registration Form

A simple and secure PHP project built with Docker and MySQL.  
Includes user registration, authentication, and environment-based configuration.  
Designed for learning, testing, and rapid prototyping of PHP applications.

---

## 🚀 Features

- 🔐 Secure password hashing (`bcrypt`)
- ⚙️ Environment-based configuration via `.env`
- 🐳 Dockerized setup (PHP-FPM, Nginx, MySQL, phpMyAdmin)
- 🧾 Simple logging system
- 🧰 Minimal dependencies — no frameworks
- 💡 PSR-12 compliant codebase

---

## 🧱 Technologies

| Tool               | Purpose                  |
|--------------------|--------------------------|
| **PHP 8.2**        | Core application runtime |
| **MySQL 8**        | Relational database      |
| **Nginx (Alpine)** | Lightweight web server   |
| **Docker Compose** | Container orchestration  |
| **Bootstrap**      | Frontend styling         |
---

## ⚙️ Setup & Installation

### 1. Clone the repository
```bash
git clone https://github.com/pithatak/Clear-PHP-registration-form
cd Clear-PHP-registration-form
```

### 2. Create your .env file
You can copy the default variables:
```bash
cp .env.example .env
```

### 3. Start the application with Docker
```bash
docker-compose up --build -d
```
###  4. Access the services
| Service        | URL                                              | Description        |
| -------------- | ------------------------------------------------ | ------------------ |
| **Web app**    | [http://localhost:54000](http://localhost:54000) | Main application   |
| **phpMyAdmin** | [http://localhost:54003](http://localhost:54003) | Database UI        |
| **Database**   | `localhost:54002`                                | MySQL exposed port |

Default MySQL credentials (from .env):
MYSQL_USER=app_user
MYSQL_PASSWORD=app_password
MYSQL_DATABASE=app_db

🧑‍💻 Author

Illia Posieva

📧 poseva41@gmail.com

🌐 GitHub: https://github.com/pithatak