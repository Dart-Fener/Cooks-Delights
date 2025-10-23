# 🍽️ Cooks Delights

Cook Delights is a cuisine website built with Laravel 10.x that allows users to explore recipes from around the world. It integrates with the free public API from [TheMealDB](https://www.themealdb.com/api.php) to fetch and display recipe data.

---

## ✨ Features

- Browse recipes from around the world
- View detailed ingredients and instructions
- Search and filters recipes by category/area(country)/tag/ingredient

---

## ⚙️ Tech Stack

- **Laravel 10.x (PHP 8.x)**
- **MySQL**
- **Docker & Docker Compose**
- **The design is based on a free Figma template by [Ilia Bortnikov](https://www.figma.com/community/file/1331351586208563684/free-cooking-recipes-blog-template), customized to fit the needs of this project**
- **[TheMealDB API](https://www.themealdb.com/api.php)**

---

## 🚀 Getting Started

### Prerequisites

- [Docker Desktop](https://www.docker.com/products/docker-desktop) installed on your system.

### Setup Instructions

**Clone Repository**
- git clone https://github.com/Dart-Fener/Cooks-Delights.git

**Run Laravel Artisan Commands via Docker**
- Using terminal move to the local folder, which contained the cloned repository and digit --**docker compose run --rm artisan**-- to run laravel artisians commands

**Run Migrations**
- Run by terminal the command --**docker compose run --rm artisan migrate**-- to create the database

**Install Node Dependencies**
- Run by terminal the command --**docker compose run --rm npm install**-- to install the node package manager

**Build Assets**
- Run by terminal the command --**docker compose run --rm npm run build**-- to build the script defined in package.json

**Start the Application**
- Execute the browser and digit into url bar --**localhost**-- to start the application

**Import Recipes into Database**
- Run by terminal the command --**docker compose run --rm artisan cooksDelight:recipes-insertion**-- to execute the command to insert recipes into database

---

## 👨‍💻 Author

- **Dart-Fener** – [GitHub Profile](https://github.com/Dart-Fener)

---

## 📝 License

This project is licensed under the [MIT License](LICENSE).
