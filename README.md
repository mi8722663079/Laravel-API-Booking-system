# Laravel Event Booking API

A robust, RESTful API built with Laravel to power an event booking system. This backend service provides comprehensive endpoints for user authentication, event browsing, and ticket booking, alongside secure administrative routes for total platform management. 

## 🚀 Features

### User Endpoints
* **Event Retrieval:** JSON endpoints to fetch upcoming events, including detailed descriptions and media URLs.
* **Booking Engine:** Secure API routes for event registration and ticket booking.
* **Authentication & Email Verification:** Token-based authentication flow with reliable email verification powered by **MailerSend**.

### Admin Endpoints
* **Event Management:** Secure CRUD operations to create, update, and delete events.
* **Media Handling:** API integration with **Spatie Media Library** to handle multipart/form-data uploads for event banners and galleries.
* **Booking Oversight:** Endpoints to track user registrations, manage event capacity, and oversee the booking lifecycle.
* **User Control:** Manage user roles, permissions, and verified statuses via administrative routes.

## 🛠️ Tech Stack

* **Framework:** Laravel (PHP) - *API Mode*
* **Database:** MySQL
* **Media Management:** [Spatie Media Library](https://spatie.be/docs/laravel-medialibrary/v11/introduction)
* **Email Delivery:** [MailerSend](https://www.mailersend.com/)

## 📋 Prerequisites

Before you begin, ensure you have the following installed:
* PHP >= 8.1
* Composer
* MySQL
* A MailerSend Account & API Key
* An API Client (e.g., Postman, Insomnia) for testing endpoints

## ⚙️ Installation

**1. Clone the repository**
```bash
git clone [https://github.com/yourusername/your-repo-name.git](https://github.com/yourusername/your-repo-name.git)
cd your-repo-name
```

**2. Install PHP dependencies**
```bash
composer install
```

**3. Setup Environment Variables**
Copy the `.env.example` file to create your `.env` file:
```bash
cp .env.example .env
```

**4. Generate Application Key**
```bash
php artisan key:generate
```

**5. Configure the Database and Services**
Open the `.env` file and update your database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
```

Configure **MailerSend** for API-based email verification:
```env
MAIL_MAILER=mailersend
MAILERSEND_API_KEY=your_mailersend_api_key
MAIL_FROM_ADDRESS="hello@yourdomain.com"
MAIL_FROM_NAME="${APP_NAME}"
```

**6. Run Migrations**
Set up the database tables (including Spatie Media Library tables and API personal access tokens):
```bash
php artisan migrate
```

**7. Create the Storage Link**
Ensure media files are accessible via public URLs in your JSON responses:
```bash
php artisan storage:link
```

**8. Run the Development Server**
```bash
php artisan serve
```
The API base URL will be `http://localhost:8000/api`.

## 📡 API Usage Notes

* **Headers:** All requests to the API should include the following header to ensure proper JSON formatting and error handling:
  ```http
  Accept: application/json
  ```
* **Authentication:** Protected routes require a Bearer token. Include it in your request headers:
  ```http
  Authorization: Bearer {your_token_here}
  ```
* **File Uploads:** When interacting with the Admin endpoints to create events with images, ensure your client is sending a `multipart/form-data` payload.

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).