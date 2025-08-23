# ITI_Blog - Laravel Blog Application

## Project Overview

ITI_Blog is a Laravel-based blog application that features post management with image uploads, comments with polymorphic relationships, user authentication, and admin functionality. The application uses Laravel's queue system for background processing of post creation.

## Features

- User authentication and authorization
- Post management (create, read, update, delete)
- Soft delete functionality for posts
- Image uploads with deduplication using hash checking
- Polymorphic relationships for images and comments
- Admin panel for user management
- Background job processing using Laravel queues
- Sluggable URLs for posts

## Requirements

- PHP 8.2 or higher
- Composer
- MySQL or compatible database
- Node.js and NPM (for frontend assets)

## Installation

### 1. Clone the repository
```bash
git clone https://github.com/AbdulRahmanKhawaga/Laravel_posts_management.git
cd Laravel_posts_management
```

### 2. Install PHP dependencies
```bash
composer install
```

### 3. Install JavaScript dependencies
```bash
npm install
npm run build
```

### 4. Configure environment variables
```bash
cp .env.example .env
php artisan key:generate
```

### 5. Run migrations
```bash
php artisan migrate
```

### 6. Create symbolic link for storage
```bash
php artisan storage:link
```

### 7. Seed the database
```bash
php artisan db:seed
```

This will create:
- 10 random users
- An admin user (email: admin@gmail.com, password: a@1234567)
- 500 sample posts

## Running the Application

### Start the development server
```bash
php artisan serve
```

### Start the queue worker
```bash
php artisan queue:work
```

**Important:** The queue worker must be running for background jobs like post creation to be processed. In a production environment, consider using a process manager like Supervisor to keep the queue worker running.

## Project Structure

### Models
- **Post**: Blog post model with soft delete functionality and sluggable URLs
- **User**: User authentication model with admin flag
- **Image**: Polymorphic model for image uploads with hash-based deduplication
- **Comment**: Polymorphic model for comments on various entities

### Key Features Implementation

#### Polymorphic Relationships
The application uses polymorphic relationships for:

1. **Images**: Any model can have associated images through the `imageable` relationship
2. **Comments**: Any model can have comments through the `commentable` relationship

#### Queue System
Post creation is handled by a background job (`ProcessPostCreation`) to improve application responsiveness. The job:

1. Creates the post record
2. Associates any uploaded images with the post
3. Logs the successful creation

#### Image Handling
The application includes sophisticated image handling:

1. Images are stored in the `storage/app/public/post-images` directory
2. Image deduplication is implemented using SHA-256 hashing
3. Original filenames are preserved for reference
4. Images are accessed via the `imageUrl` accessor in the Post model

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## License

This project is open-sourced software licensed under the MIT license.
