# Laravel Blog Project - Technical Documentation

## Project Overview
**Project Name:** Oredoo - Laravel Multi User Blog Project  
**Framework:** Laravel 10 (PHP ^8.1)  
**Type:** Multi-user blog platform with role-based access control  
**Database:** MySQL  
**Created Date:** October 2023  

---

## Key Features
- **Multi-User System:** Admin, Author, and Visitor roles
- **Content Management:** Posts, categories, tags, pages
- **Comment System:** Nested comments with guest commenting
- **Media Library:** Upload and manage media files
- **Featured Posts:** Mark posts as featured
- **Soft Deletes:** Trash and restore functionality for posts, comments, categories, and pages
- **Dynamic Menus:** Customizable header and footer menus
- **Social Media Integration:** User profiles and site-wide social links
- **Search Functionality:** Search posts by title and content
- **Site Settings:** Configurable site-wide settings

---

## User Roles & Permissions

### Role Constants (User Model)
```php
User::IS_VISITOR = 1  // Basic user, can comment
User::IS_AUTHOR = 2   // Can create and manage own posts
User::IS_ADMIN = 3    // Full access to all features
```

### Authorization Gates
Defined in `AuthServiceProvider.php`:
- **update-post**: Admin can update any post, authors only their own
- **update-comment**: Admin can update any comment, authors only comments on their posts
- **update-media**: Admin can update any media, users only their own

### Middleware
- `auth`: Authentication check (redirects to login if not authenticated)
- `admin`: Restricts access to admin role only (role == 3)

---

## Database Models & Relationships

### User Model
**Table:** `users`  
**Key Fields:**
- id, name, username, email, password
- profile (image), about (bio)
- role (1=Visitor, 2=Author, 3=Admin)
- status (boolean - active/inactive)
- Social media: facebook, twitter, instagram, linkedin, youtube

**Relationships:**
- `hasMany` → Posts
- `hasMany` → Comments
- `hasMany` → Media

---

### Post Model
**Table:** `posts`  
**Key Fields:**
- id, user_id, category_id
- title, slug, content
- thumbnail (image)
- views (counter)
- is_featured (boolean)
- enable_comment (boolean)
- status (boolean - published/draft)
- deleted_at (soft deletes)

**Relationships:**
- `belongsTo` → User
- `belongsTo` → Category
- `belongsToMany` → Tags (pivot: post_tag)
- `hasMany` → Comments

**Methods:**
- `readTime()`: Calculates reading time based on word count (~200 words/min)

**Observers:** PostObserver (handles slug generation, etc.)

---

### Category Model
**Table:** `categories`  
**Key Fields:**
- id, title, slug
- description, image
- status (boolean)
- deleted_at (soft deletes)

**Relationships:**
- `hasMany` → Posts

**Observers:** CategoryObserver

---

### Tag Model
**Table:** `tags`  
**Key Fields:**
- id, name

**Relationships:**
- `belongsToMany` → Posts (pivot: post_tag)

---

### Comment Model
**Table:** `comments`  
**Key Fields:**
- id, post_id, user_id, parent_id
- message
- name, email (for guest comments)
- status (boolean - approved/pending)
- deleted_at (soft deletes)

**Relationships:**
- `belongsTo` → User (nullable for guest comments)
- `belongsTo` → Post
- `hasMany` → replies (self-referencing via parent_id)

---

### Page Model
**Table:** `pages`  
**Key Fields:**
- id, title, slug, content
- status (boolean)
- deleted_at (soft deletes)

---

### Media Model
**Table:** `media`  
**Key Fields:**
- id, user_id, file_name

**Relationships:**
- `belongsTo` → User

---

### Other Models
- **SiteSetting**: Site-wide configuration
- **SocialMedia**: Site social media links
- **Menu**: Header/footer navigation menus

---

## Application Structure

### Routes (web.php)

#### Frontend Routes (No Authentication Required)
**Prefix:** `/`  
**Name Prefix:** `frontend.`

| Method | URI | Controller@Method | Description |
|--------|-----|-------------------|-------------|
| GET | / | HomeController@index | Homepage |
| GET | /search | SearchController@index | Search posts |
| GET | /post/{slug} | PostController@index | Single post view |
| POST | /comment/{id} | CommentController@index | Submit comment |
| POST | /comment-reply | CommentController@reply | Submit reply |
| GET | /category/{slug} | CategoryController@index | Category posts |
| GET | /user/{username} | UserController@index | User profile |
| GET | /tag/{name} | TagController@index | Tag posts |
| GET | /page/{slug} | PageController@index | Static page |

---

#### Auth Routes
**Prefix:** `/`  
**Name Prefix:** `auth.`

| Method | URI | Controller@Method | Description |
|--------|-----|-------------------|-------------|
| GET | /signup | SignupController@index | Signup form |
| POST | /signup | SignupController@signup | Register user |
| GET | /login | LoginController@index | Login form |
| POST | /login | LoginController@login | Authenticate |
| POST | /logout | LogoutController@index | Logout |

---

#### Dashboard Routes
**Prefix:** `/dashboard`  
**Name Prefix:** `dashboard.`  
**Middleware:** `auth`

##### Posts (Authors & Admin)
| Method | URI | Controller@Method | Middleware | Description |
|--------|-----|-------------------|------------|-------------|
| GET | /posts | PostController@index | auth | List posts |
| GET | /posts/create | PostController@create | auth | Create form |
| POST | /posts | PostController@store | auth | Store post |
| GET | /posts/{id}/edit | PostController@edit | auth | Edit form |
| PUT/PATCH | /posts/{id} | PostController@update | auth | Update post |
| DELETE | /posts/{id} | PostController@destroy | auth | Soft delete |
| GET | /posts/{id}/status | PostController@status | auth | Toggle status |
| GET | /posts/{id}/featured | PostController@featured | auth | Toggle featured |
| GET | /posts/{id}/comment | PostController@comment | auth | Toggle comments |
| GET | /posts/trashed | PostController@trashed | auth | Trashed posts |
| GET | /posts/{id}/restore | PostController@restore | auth | Restore post |
| DELETE | /posts/{id}/delete | PostController@delete | auth | Force delete |

##### Categories (Admin Only)
| Method | URI | Controller@Method | Middleware | Description |
|--------|-----|-------------------|------------|-------------|
| GET | /categories | CategoryController@index | admin | List categories |
| GET | /categories/create | CategoryController@create | admin | Create form |
| POST | /categories | CategoryController@store | admin | Store category |
| GET | /categories/{id}/edit | CategoryController@edit | admin | Edit form |
| PUT/PATCH | /categories/{id} | CategoryController@update | admin | Update |
| DELETE | /categories/{id} | CategoryController@destroy | admin | Soft delete |
| GET | /categories/{id}/status | CategoryController@status | admin | Toggle status |
| GET | /categories/trashed | CategoryController@trashed | admin | Trashed list |
| GET | /categories/{id}/restore | CategoryController@restore | admin | Restore |
| DELETE | /categories/{id}/delete | CategoryController@delete | admin | Force delete |

##### Tags (Admin Only)
| Method | URI | Controller@Method | Middleware | Description |
|--------|-----|-------------------|------------|-------------|
| GET | /tags/index | TagController@index | admin | List tags |
| DELETE | /tags/{id}/destroy | TagController@destroy | admin | Delete tag |

##### Comments (Authors & Admin)
| Method | URI | Controller@Method | Middleware | Description |
|--------|-----|-------------------|------------|-------------|
| GET | /comments | CommentController@index | auth | List comments |
| GET | /comments/{id} | CommentController@show | auth | View comment |
| DELETE | /comments/{id} | CommentController@destroy | auth | Soft delete |
| GET | /comments/{id}/status | CommentController@status | auth | Toggle status |
| GET | /comments/trashed | CommentController@trashed | auth | Trashed list |
| GET | /comments/{id}/restore | CommentController@restore | auth | Restore |
| DELETE | /comments/{id}/delete | CommentController@delete | auth | Force delete |

##### Media Library (Authors & Admin)
| Method | URI | Controller@Method | Middleware | Description |
|--------|-----|-------------------|------------|-------------|
| GET | /media | MediaController@index | auth | List media |
| GET | /media/create | MediaController@create | auth | Upload form |
| POST | /media | MediaController@store | auth | Upload file |
| DELETE | /media/{id} | MediaController@destroy | auth | Delete file |

##### Pages (Admin Only)
| Method | URI | Controller@Method | Middleware | Description |
|--------|-----|-------------------|------------|-------------|
| GET | /pages | PageController@index | admin | List pages |
| GET | /pages/create | PageController@create | admin | Create form |
| POST | /pages | PageController@store | admin | Store page |
| GET | /pages/{id}/edit | PageController@edit | admin | Edit form |
| PUT/PATCH | /pages/{id} | PageController@update | admin | Update page |
| DELETE | /pages/{id} | PageController@destroy | admin | Soft delete |
| GET | /pages/{id}/status | PageController@status | admin | Toggle status |
| GET | /pages/trashed | PageController@trashed | admin | Trashed list |
| GET | /pages/{id}/restore | PageController@restore | admin | Restore |
| DELETE | /pages/{id}/delete | PageController@delete | admin | Force delete |

##### Users (Admin Only)
| Method | URI | Controller@Method | Middleware | Description |
|--------|-----|-------------------|------------|-------------|
| GET | /users | UserController@index | admin | List users |
| GET | /users/create | UserController@create | admin | Create form |
| POST | /users | UserController@store | admin | Create user |
| GET | /users/{id} | UserController@show | admin | View user |
| GET | /users/{id}/edit | UserController@edit | admin | Edit form |
| PUT/PATCH | /users/{id} | UserController@update | admin | Update user |
| DELETE | /users/{id} | UserController@destroy | admin | Delete user |
| GET | /users/{id}/status | UserController@status | admin | Toggle status |

##### Settings (Mixed Permissions)
| Method | URI | Controller@Method | Middleware | Description |
|--------|-----|-------------------|------------|-------------|
| GET | /settings/site-settings | SiteSettingController@index | admin | Site settings |
| POST | /settings/site-settings | SiteSettingController@update | admin | Update settings |
| GET | /settings/profile | ProfileController@index | auth | User profile |
| POST | /settings/profile | ProfileController@update | auth | Update profile |
| GET | /settings/change-password | ProfileController@password | auth | Password form |
| POST | /settings/change-password | ProfileController@passwordUpdate | auth | Change password |
| GET | /settings/social-media | SocialMediaController@index | admin | Social links |
| POST | /settings/social-media | SocialMediaController@add | admin | Add link |
| GET | /settings/social-media/{id}/status | SocialMediaController@status | admin | Toggle status |
| DELETE | /settings/social-media/{id}/delete | SocialMediaController@delete | admin | Delete link |
| GET | /settings/menus/header | MenuController@header | admin | Header menu |
| POST | /settings/menus/header | MenuController@headerUpdate | admin | Update header |
| GET | /settings/menus/footer | MenuController@footer | admin | Footer menu |
| POST | /settings/menus/footer | MenuController@footerUpdate | admin | Update footer |

---

## Controllers Overview

### Dashboard Controllers
Located in: `app/Http/Controllers/Dashboard/`

1. **HomeController**: Dashboard homepage with statistics
2. **PostController**: CRUD operations for posts (215 lines)
3. **CategoryController**: CRUD operations for categories
4. **TagController**: Tag management
5. **CommentController**: Comment moderation
6. **MediaController**: File upload and management
7. **PageController**: Static pages management
8. **UserController**: User management (admin only)
9. **ProfileController**: User profile and password updates
10. **SiteSettingController**: Site-wide configuration
11. **SocialMediaController**: Social media links
12. **MenuController**: Navigation menu management

### Frontend Controllers
Located in: `app/Http/Controllers/Frontend/`

1. **HomeController**: Homepage with featured/popular posts
2. **PostController**: Single post display
3. **CategoryController**: Category archive
4. **TagController**: Tag archive
5. **UserController**: Author profile page
6. **PageController**: Static page display
7. **CommentController**: Comment submission
8. **SearchController**: Search functionality

### Auth Controllers
Located in: `app/Http/Controllers/Auth/`

1. **SignupController**: User registration
2. **LoginController**: User authentication
3. **LogoutController**: User logout

---

## Key Controller Logic (PostController Example)

### Post Creation Flow
1. Validate request data (title, slug, content, category, tags, thumbnail)
2. Upload thumbnail to `public/uploads/post/` with MD5 hash filename
3. Create post record with authenticated user ID
4. Set status: Authors → Draft (0), Admin → As selected
5. Attach tags (create new tags if needed)
6. Redirect to posts index with success message

### Post Update Flow
1. Check post exists and user has permission (Gate: update-post)
2. Validate data (unique slug ignored for current post)
3. Update post fields
4. If new thumbnail uploaded:
   - Delete old thumbnail file
   - Upload new thumbnail
5. Sync tags (create new, remove old)
6. Redirect with success message

### Post Status Toggle
- Authors can only toggle their own posts
- Admin can toggle any post
- Role check: Author role (1) cannot toggle status

### Soft Delete & Restore
- **Soft Delete**: Moves to trash (deleted_at timestamp)
- **Restore**: Checks if category still exists (not trashed)
- **Force Delete**: Permanently deletes post, thumbnail, tags relation, and comments

---

## File Storage Structure

```
public/
├── uploads/
│   ├── post/              # Post thumbnails
│   ├── category/          # Category images
│   ├── profile/           # User profile pictures
│   └── media/             # Media library files
└── assets/
    ├── frontend/          # Frontend CSS/JS
    └── dashboard/         # Dashboard CSS/JS/plugins
```

---

## Database Migrations (Chronological)

1. `create_users_table` (2014-10-12)
2. `create_password_reset_tokens_table` (2014-10-12)
3. `create_failed_jobs_table` (2019-08-19)
4. `create_personal_access_tokens_table` (2019-12-14)
5. `create_posts_table` (2023-10-11)
6. `create_categories_table` (2023-10-11)
7. `create_comments_table` (2023-10-11)
8. `create_tags_table` (2023-10-13)
9. `create_post_tag_table` (2023-10-13) - Pivot table
10. `create_site_settings_table` (2023-10-23)
11. `create_social_media_table` (2023-10-23)
12. `create_menus_table` (2023-10-23)
13. `add_social_media_to_user_table` (2023-10-23)
14. `create_media_table` (2023-10-23)
15. `create_pages_table` (2023-10-24)

---

## Validation Rules (Post Example)

### Store Post
```php
"title" => ["required", "string"]
"slug" => ["required", "string", "unique:posts,slug"]
"content" => ["required", "string"]
"category" => ["required", "exists:categories,id"]
"tags" => ["nullable", "array"]
"featured" => ["nullable", Rule::in(["0", "1"])]
"comment" => ["nullable", Rule::in(["0", "1"])]
"status" => ["required", Rule::in(["0", "1"])]
"thumbnail" => ["required", "image"]
```

### Update Post
- Same as store, but slug unique rule ignores current post ID
- Thumbnail becomes optional

---

## Authentication & Authorization Summary

### Authentication
- Session-based authentication (Laravel Sanctum included but not used for API)
- Custom middleware: `AuthMiddleware` redirects to login if not authenticated
- Redirect route: `route("auth.login")`

### Authorization Levels
1. **Public Routes**: No authentication required (frontend)
2. **Authenticated Routes**: Any logged-in user (auth middleware)
3. **Author Routes**: Authors can manage their own content
4. **Admin Routes**: Admin has full access (admin middleware + role check)

### Gate Checks
- Used in controllers to verify ownership before updates
- Example: `Gate::allows("update-post", $post)`
- Returns 404 if unauthorized (not 403)

---

## Observers

### PostObserver
Located: `app/Observers/PostObserver.php`  
Handles automatic slug generation and other post-related events

### CategoryObserver
Located: `app/Observers/CategoryObserver.php`  
Handles category-specific events

---

## Dependencies (composer.json)

### Core Requirements
- **PHP**: ^8.1
- **Laravel Framework**: ^10.10
- **Guzzle HTTP**: ^7.2 (for external HTTP requests)
- **Laravel Sanctum**: ^3.2 (API authentication)
- **Laravel Tinker**: ^2.8 (REPL tool)

### Dev Dependencies
- **Faker**: ^1.9.1 (test data generation)
- **Laravel Pint**: ^1.0 (code style)
- **PHPUnit**: ^10.1 (testing)
- **Spatie Ignition**: ^2.0 (error pages)

---

## View Structure

```
resources/views/
├── auth/                  # Login, signup forms
├── frontend/              # Public-facing pages
├── dashboard/             # Admin panel pages
├── components/            # Reusable Blade components
└── vendor/                # Package views
```

---

## Important Notes

### Post Status Logic
- **Author Role (1)**: Cannot publish posts, always saved as draft
- **Author Role (2)**: Can publish own posts
- **Admin Role (3)**: Full control over all posts

### File Upload Security
- Images renamed with MD5 hash + timestamp
- Stored in public directory (accessible via URL)
- Old files deleted when updating

### Soft Deletes
- Posts, categories, comments, and pages use soft deletes
- Trashed items can be restored
- Force delete permanently removes records and associated files
- Restoring posts requires parent category to not be trashed

### Tag System
- Tags created dynamically (firstOrCreate)
- Tag names stored in lowercase
- Many-to-many relationship with posts
- Tags are NOT soft deleted (permanent)

---

## Installation & Setup

### Requirements
- PHP ^8.1
- Composer
- MySQL database
- Node.js & NPM (for frontend assets)

### Installation Steps
```bash
# Clone repository
git clone <repository-url>
cd laravel-blog-project

# Install dependencies
composer install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Configure database in .env
# DB_DATABASE, DB_USERNAME, DB_PASSWORD

# Run migrations
php artisan migrate

# Seed database (creates admin user)
php artisan db:seed

# Start development server
php artisan serve
```

### Default Admin Credentials
- **Username**: admin
- **Password**: admin

---

## Common Queries & Patterns

### Eager Loading (N+1 Prevention)
```php
// Posts with relationships
Post::with(["category", "tags", "user"])
    ->withCount(["comments"])
    ->orderBy("id", "DESC")
    ->paginate(20);
```

### Soft Deletes Query
```php
// Only trashed posts
Post::onlyTrashed()->get();

// Include trashed categories
Post::with(["category" => function($q) {
    $q->withTrashed();
}])->get();
```

### Scoped Queries (Author vs Admin)
```php
if (Auth::user()->role == 3) {
    // Admin sees all posts
    $posts = Post::all();
} else {
    // Author sees only their posts
    $posts = Post::where("user_id", Auth::id())->get();
}
```

---

## API Endpoints
Currently, the project does not have active API routes (api.php is empty), but the infrastructure exists via Laravel Sanctum.

---

## Future Enhancement Possibilities
1. API implementation with Sanctum tokens
2. Email verification for users
3. Password reset functionality
4. Post scheduling (publish at specific time)
5. Multiple image upload for posts
6. SEO meta tags management
7. RSS feed generation
8. Post revisions/versioning
9. User notifications
10. Activity logs

---

## Troubleshooting Common Issues

### Permission Errors
- Ensure storage and bootstrap/cache directories are writable
- Run: `chmod -R 775 storage bootstrap/cache`

### File Upload Issues
- Check upload_max_filesize in php.ini
- Ensure public/uploads directories exist and are writable

### Session/Cache Issues
- Clear cache: `php artisan cache:clear`
- Clear config: `php artisan config:clear`
- Clear views: `php artisan view:clear`

---

## Security Considerations

1. **CSRF Protection**: Enabled on all POST/PUT/DELETE requests
2. **Password Hashing**: Automatic via Laravel's hashing
3. **Mass Assignment**: Protected via $fillable properties
4. **SQL Injection**: Protected via Eloquent ORM
5. **File Uploads**: Validated for image types
6. **Authorization**: Gate-based permission checks

---

## Testing Structure
- Feature tests: `tests/Feature/`
- Unit tests: `tests/Unit/`
- Run tests: `php artisan test` or `vendor/bin/phpunit`

---

**Document Version:** 1.0  
**Last Updated:** February 7, 2026  
**Maintained by:** Development Team
