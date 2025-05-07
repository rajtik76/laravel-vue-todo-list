# Laravel Inertia Todo List Application

This project is a simple Todo list application built with Laravel 12, Inertia.js, Vue 3, and Tailwind CSS. It provides features for creating, toggling, and deleting todos, with support for dark mode and form validation.

---

## Features

- List todos specific to authenticated users
- Create new todos with validation errors displayed
- Toggle completion status of todos
- Delete todos with confirmation
- Dark mode support with toggle functionality
- Real-time updates using Inertia.js

---

## Requirements

- PHP 8.2 or higher
- Composer
- Node.js & npm

---

## Installation

### Backend dependencies
```bash
bash composer install php artisan migrate
``` 

### Frontend dependencies
```
bash npm install npm run build
``` 

### Run the development server
```
bash php artisan serve npm run dev
``` 

The app will be accessible at `http://localhost:8000`.

---

## Usage

### Authentication

This project assumes that you have user authentication set up. Use the provided login/register routes to create an account and log in.

### Managing Todos

- Click **New Todo** to open the modal form
- Fill in the details and click **Add**
- Click on a todo item to toggle its completion status
- Click the delete button to remove a todo after confirmation

### Dark Mode

Use the **Toggle Dark Mode** button to switch themes.

---

## Code Structure

- `routes/web.php`: Defines the web routes, including Todo CRUD routes.
- `app/Http/Requests/TodoCreateRequest.php`: Validation for creating todos.
- `app/Http/Controllers/TodoController.php`: Handles business logic for todos.
- `resources/views`: Not used directly; frontend is using Vue components.
- `resources/js`: Vue components for your frontend.
- `tailwind.config.js`: Tailwind CSS configuration with dark mode support enabled.

---

## License

This project is open-source and available under the MIT License.
```
